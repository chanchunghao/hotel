<?php

namespace Acme\Component\Resource\Criteria;

use Acme\Component\Common\Collection\Enumerable;
use Acme\Component\Common\Utility\String;

abstract class AbstractCriteria
{
    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $sorters = [];

    /**
     * @return array
     */
    abstract public function getAllFilterKeys();

    /**
     * @return array
     */
    abstract public function getAllSortKeys();

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters)
    {
        $this->clearFilters();

        foreach ($filters as $filterBy => $value) {
            $this->addFilter($filterBy, $value);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clearFilters()
    {
        $this->filters = [];

        return $this;
    }

    /**
     * @param string $filterBy
     * @param string $value
     * @throw \InvalidArgumentException
     * @return $this
     */
    public function addFilter($filterBy, $value)
    {
        $this->filters[$this->normalizeKey($filterBy, $this->getAllFilterKeys())] = $value;

        return $this;
    }

    /**
     * @param string $filterBy
     * @return $this
     */
    public function removeFilter($filterBy)
    {
        unset($this->filters[$this->normalizeKey($filterBy, $this->getAllFilterKeys())]);

        return $this;
    }

    /**
     * @return array
     */
    public function getSorters()
    {
        return $this->sorters;
    }

    /**
     * @param array $sorters
     * @return $this
     */
    public function setSorters(array $sorters)
    {
        $this->clearSorters();

        foreach ($sorters as $sortBy => $direction) {
            $this->addSorter($sortBy, $direction);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clearSorters()
    {
        $this->sorters = [];

        return $this;
    }

    /**
     * @param string|int $sortBy
     * @param bool|string $direction
     * @throw \InvalidArgumentException
     * @return $this
     */
    public function addSorter($sortBy, $direction = 'DESC')
    {
        $key = $this->normalizeKey($sortBy, $this->getAllSortKeys());
        $value = $this->normalizeSortDirection($direction);
        $this->sorters[$key] = $value;

        return $this;
    }

    /**
     * @param string|int $sortBy
     * @return $this
     */
    public function removeSorter($sortBy)
    {
        unset($this->sorters[$this->normalizeKey($sortBy, $this->getAllSortKeys())]);

        return $this;
    }

    /**
     * @param string $key
     * @param array $keys
     * @return string
     */
    protected function normalizeKey($key, array $keys)
    {
        $selector = function ($key) {
            return String::toCamelCase($key);
        };

        $keys = Enumerable::from($keys)->select($selector)->toArray();

        switch (true) {
            case is_string($key) && in_array(String::toCamelCase($key), $keys):
                return String::toCamelCase($key);

            case is_integer($key) && $key >= 0 && $key < count($keys):
                return $keys[$key];

            default:
                $message = String::format('Key {0} is invalid. Accept keys: {1}', $key, String::join(', ', $keys));
                throw new \InvalidArgumentException($message);
        }
    }

    /**
     * @param bool|string $direction
     * @return string
     */
    protected function normalizeSortDirection($direction)
    {
        switch (true) {
            case is_string($direction) && in_array($direction, ['asc', 'desc', 'Asc', 'Desc', 'ASC', 'DESC']):
                return strtoupper($direction);

            case is_bool($direction):
            case is_numeric($direction) && in_array($direction, [1, 0]):
            case is_string($direction) && in_array($direction, ['1', '0', 'true', 'false', 'True', 'False']):
                return filter_var($direction, FILTER_VALIDATE_BOOLEAN) ? 'ASC' : 'DESC';

            default:
                throw new \InvalidArgumentException("Direction $direction is invalid.");
        }
    }
}
