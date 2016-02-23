<?php

namespace Acme\Component\Resource\Criteria;

class SearchCriteria extends AbstractSearchCriteria
{
    /**
     * @var string
     */
    protected $entityClassName;

    /**
     * @var MetadataDriverInterface
     */
    protected $driver;

    public function __construct($entityClassName, MetadataDriverInterface $driver)
    {
        $this->entityClassName = $entityClassName;
        $this->driver = $driver;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllSearchKeys()
    {
        return $this->driver->getSearchKeys($this->entityClassName);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllSortKeys()
    {
        return $this->driver->getSortKeys($this->entityClassName);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllFilterKeys()
    {
        return $this->driver->getFilterKeys($this->entityClassName);
    }
}
