<?php

namespace Acme\Component\Common\Collection;

use YaLinqo\Enumerable as EnumerableBase;

/**
 * {@inheritdoc}
 */
class Enumerable implements EnumerableInterface
{
    /**
     * @var EnumerableBase $enumerable
     */
    protected $enumerable;

    /**
     * @internal
     * @param EnumerableBase $enumerable
     */
    public function __construct(EnumerableBase $enumerable)
    {
        $this->enumerable = $enumerable;
    }

    /**
     * {@inheritdoc}
     */
    public static function from($source)
    {
        return $source instanceof Enumerable ? $source : new self(EnumerableBase::from($source));
    }

    /**
     * {@inheritdoc}
     */
    public static function range($start, $count, $step = 1)
    {
        return new self(EnumerableBase::range($start, $count, $step));
    }

    /**
     * {@inheritdoc}
     */
    public static function rangeDown($start, $count, $step = 1)
    {
        return new self(EnumerableBase::rangeDown($start, $count, $step));
    }

    /**
     * {@inheritdoc}
     */
    public static function rangeTo($start, $end, $step = 1)
    {
        return new self(EnumerableBase::rangeTo($start, $end, $step));
    }

    /**
     * {@inheritdoc}
     */
    public static function split($subject, $pattern, $flags = 0)
    {
        return new self(EnumerableBase::split($subject, $pattern, $flags));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->enumerable->getIterator();
    }

    /**
     * {@inheritdoc}
     */
    public function count($predicate = null)
    {
        return $this->enumerable->count($predicate);
    }

    /**
     * {@inheritdoc}
     */
    public function cast($type)
    {
        return new self($this->enumerable->cast($type));
    }

    /**
     * {@inheritdoc}
     */
    public function ofType($type)
    {
        return new self($this->enumerable->ofType($type));
    }

    /**
     * {@inheritdoc}
     */
    public function select($selectorValue, $selectorKey = null)
    {
        return new self($this->enumerable->select($selectorValue, $selectorKey));
    }

    /**
     * {@inheritdoc}
     */
    public function selectMany($collectionSelector = null, $resultSelectorValue = null, $resultSelectorKey = null)
    {
        return new self($this->enumerable->selectMany($collectionSelector, $resultSelectorValue, $resultSelectorKey));
    }

    /**
     * {@inheritdoc}
     */
    public function where($predicate)
    {
        return new self($this->enumerable->where($predicate));
    }

    /**
     * {@inheritdoc}
     */
    public function orderBy($keySelector = null, $comparer = null)
    {
        return new OrderedEnumerable($this->enumerable->orderBy($keySelector, $comparer));
    }

    /**
     * {@inheritdoc}
     */
    public function orderByDescending($keySelector = null, $comparer = null)
    {
        return new OrderedEnumerable($this->enumerable->orderByDescending($keySelector, $comparer));
    }

    /**
     * {@inheritdoc}
     */
    public function groupJoin(
        $inner,
        $outerKeySelector = null,
        $innerKeySelector = null,
        $resultSelectorValue = null,
        $resultSelectorKey = null
    ) {
        return new self(
            $this->enumerable->groupJoin(
                $inner,
                $outerKeySelector,
                $innerKeySelector,
                $resultSelectorValue,
                $resultSelectorKey
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function join(
        $inner,
        $outerKeySelector = null,
        $innerKeySelector = null,
        $resultSelectorValue = null,
        $resultSelectorKey = null
    ) {
        return new self(
            $this->enumerable->join(
                $inner,
                $outerKeySelector,
                $innerKeySelector,
                $resultSelectorValue,
                $resultSelectorKey
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function groupBy(
        $keySelector = null,
        $valueSelector = null,
        $resultSelectorValue = null,
        $resultSelectorKey = null
    ) {
        return new self(
            $this->enumerable->groupBy(
                $keySelector,
                $valueSelector,
                $resultSelectorValue,
                $resultSelectorKey
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function aggregate($func, $seed = null)
    {
        return new self($this->enumerable->aggregate($func, $seed));
    }

    /**
     * {@inheritdoc}
     */
    public function aggregateOrDefault($func, $seed = null, $default = null)
    {
        return new self($this->enumerable->aggregateOrDefault($func, $seed, $default));
    }

    /**
     * {@inheritdoc}
     */
    public function average($selector = null)
    {
        return $this->enumerable->average($selector);
    }

    /**
     * {@inheritdoc}
     */
    public function max($selector = null)
    {
        return $this->enumerable->max($selector);
    }

    /**
     * {@inheritdoc}
     */
    public function min($selector = null)
    {
        return $this->enumerable->min($selector);
    }

    /**
     * {@inheritdoc}
     */
    public function sum($selector = null)
    {
        return $this->enumerable->sum($selector);
    }

    /**
     * {@inheritdoc}
     */
    public function all($predicate)
    {
        return $this->enumerable->all($predicate);
    }

    /**
     * {@inheritdoc}
     */
    public function any($predicate = null)
    {
        return $this->enumerable->any($predicate);
    }

    /**
     * {@inheritdoc}
     */
    public function contains($value)
    {
        return $this->enumerable->contains($value);
    }

    /**
     * {@inheritdoc}
     */
    public function distinct($keySelector = null)
    {
        return new self($this->enumerable->distinct($keySelector));
    }

    /**
     * {@inheritdoc}
     */
    public function except($other, $keySelector = null)
    {
        return new self($this->enumerable->except($other, $keySelector));
    }

    /**
     * {@inheritdoc}
     */
    public function intersect($other, $keySelector = null)
    {
        return new self($this->enumerable->intersect($other, $keySelector));
    }

    /**
     * {@inheritdoc}
     */
    public function union($other, $keySelector = null)
    {
        return new self($this->enumerable->union($other, $keySelector));
    }

    /**
     * {@inheritdoc}
     */
    public function elementAt($key)
    {
        return $this->enumerable->elementAt($key);
    }

    /**
     * {@inheritdoc}
     */
    public function elementAtOrDefault($key, $default = null)
    {
        return $this->enumerable->elementAtOrDefault($key, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function first($predicate = null)
    {
        return $this->enumerable->first($predicate);
    }

    /**
     * {@inheritdoc}
     */
    public function firstOrDefault($default = null, $predicate = null)
    {
        return $this->enumerable->firstOrDefault($default, $predicate);
    }

    /**
     * {@inheritdoc}
     */
    public function firstOrFallback($fallback, $predicate = null)
    {
        return $this->enumerable->firstOrFallback($fallback, $predicate);
    }

    /**
     * {@inheritdoc}
     */
    public function last($predicate = null)
    {
        return $this->enumerable->last($predicate);
    }

    /**
     * {@inheritdoc}
     */
    public function lastOrDefault($default = null, $predicate = null)
    {
        return $this->enumerable->lastOrDefault($default, $predicate);
    }

    /**
     * {@inheritdoc}
     */
    public function lastOrFallback($fallback, $predicate = null)
    {
        return $this->enumerable->lastOrFallback($fallback, $predicate);
    }

    /**
     * {@inheritdoc}
     */
    public function single($predicate = null)
    {
        return $this->enumerable->single($predicate);
    }

    /**
     * {@inheritdoc}
     */
    public function singleOrDefault($default = null, $predicate = null)
    {
        return $this->enumerable->singleOrDefault($default, $predicate);
    }

    /**
     * {@inheritdoc}
     */
    public function singleOrFallback($fallback, $predicate = null)
    {
        return $this->enumerable->singleOrFallback($fallback, $predicate);
    }

    /**
     * {@inheritdoc}
     */
    public function indexOf($value)
    {
        return $this->enumerable->indexOf($value);
    }

    /**
     * {@inheritdoc}
     */
    public function lastIndexOf($value)
    {
        return $this->enumerable->lastIndexOf($value);
    }

    /**
     * {@inheritdoc}
     */
    public function findIndex($predicate)
    {
        return $this->enumerable->findIndex($predicate);
    }

    /**
     * {@inheritdoc}
     */
    public function findLastIndex($predicate)
    {
        return $this->enumerable->findLastIndex($predicate);
    }

    /**
     * {@inheritdoc}
     */
    public function skip($count)
    {
        return new self($this->enumerable->skip($count));
    }

    /**
     * {@inheritdoc}
     */
    public function skipWhile($predicate)
    {
        return new self($this->enumerable->skipWhile($predicate));
    }

    /**
     * {@inheritdoc}
     */
    public function take($count)
    {
        return new self($this->enumerable->take($count));
    }

    /**
     * {@inheritdoc}
     */
    public function takeWhile($predicate)
    {
        return new self($this->enumerable->takeWhile($predicate));
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->enumerable->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function toArrayDeep()
    {
        return $this->enumerable->toArrayDeep();
    }

    /**
     * {@inheritdoc}
     */
    public function toList()
    {
        return $this->enumerable->toList();
    }

    /**
     * {@inheritdoc}
     */
    public function toListDeep()
    {
        return $this->enumerable->toListDeep();
    }

    /**
     * {@inheritdoc}
     */
    public function toDictionary($keySelector = null, $valueSelector = null)
    {
        return $this->enumerable->toDictionary($keySelector, $valueSelector);
    }

    /**
     * {@inheritdoc}
     */
    public function toJSON($options = 0)
    {
        return $this->enumerable->toJSON($options);
    }

    /**
     * {@inheritdoc}
     */
    public function toLookup($keySelector = null, $valueSelector = null)
    {
        return $this->enumerable->toLookup($keySelector, $valueSelector);
    }

    /**
     * {@inheritdoc}
     */
    public function toKeys()
    {
        return $this->enumerable->toKeys();
    }

    /**
     * {@inheritdoc}
     */
    public function toValues()
    {
        return $this->enumerable->toValues();
    }

    /**
     * {@inheritdoc}
     */
    public function toString($separator = '', $valueSelector = null)
    {
        return $this->enumerable->toString($separator, $valueSelector);
    }

    /**
     * {@inheritdoc}
     */
    public function each($action = null)
    {
        return $this->enumerable->each($action);
    }
}
