<?php

namespace Acme\Component\Common\Collection;

/**
 * A sequence of values indexed by keys, the primary class of YaLinqo.
 * <p>A sequence of values indexed by keys, which supports various operations:
 * generation, projection, filtering, ordering, joining, grouping, aggregation etc.
 * <p>To create a Enumerable, call {@link Enumerable::from} (aliased as a global function {@link from})
 * or any of the generation functions.
 * To convert to array, call {@link Enumerable::toArrayDeep} or any of the conversion functions.
 * <p>Internally, it is a wrapper around a lazily created iterator.
 * The wrapped iterator is evaluated when {@link getIterator} is called.
 * @see from
 */
interface EnumerableInterface extends \IteratorAggregate
{
    /**
     * {@inheritdoc}
     */
    public static function from($source);

    /**
     * {@inheritdoc}
     */
    public static function range($start, $count, $step = 1);

    /**
     * {@inheritdoc}
     */
    public static function rangeDown($start, $count, $step = 1);

    /**
     * {@inheritdoc}
     */
    public static function rangeTo($start, $end, $step = 1);

    /**
     * {@inheritdoc}
     */
    public static function split($subject, $pattern, $flags = 0);

    /**
     * {@inheritdoc}
     */
    public function cast($type);

    /**
     * {@inheritdoc}
     */
    public function ofType($type);

    /**
     * {@inheritdoc}
     */
    public function select($selectorValue, $selectorKey = null);

    /**
     * {@inheritdoc}
     */
    public function selectMany($collectionSelector = null, $resultSelectorValue = null, $resultSelectorKey = null);

    /**
     * {@inheritdoc}
     */
    public function where($predicate);

    /**
     * {@inheritdoc}
     */
    public function orderBy($keySelector = null, $comparer = null);

    /**
     * {@inheritdoc}
     */
    public function orderByDescending($keySelector = null, $comparer = null);

    /**
     * {@inheritdoc}
     */
    public function groupJoin(
        $inner,
        $outerKeySelector = null,
        $innerKeySelector = null,
        $resultSelectorValue = null,
        $resultSelectorKey = null
    );

    /**
     * {@inheritdoc}
     */
    public function join(
        $inner,
        $outerKeySelector = null,
        $innerKeySelector = null,
        $resultSelectorValue = null,
        $resultSelectorKey = null
    );

    /**
     * {@inheritdoc}
     */
    public function groupBy(
        $keySelector = null,
        $valueSelector = null,
        $resultSelectorValue = null,
        $resultSelectorKey = null
    );

    /**
     * {@inheritdoc}
     */
    public function aggregate($func, $seed = null);

    /**
     * {@inheritdoc}
     */
    public function aggregateOrDefault($func, $seed = null, $default = null);

    /**
     * {@inheritdoc}
     */
    public function average($selector = null);

    /**
     * {@inheritdoc}
     */
    public function count($predicate = null);

    /**
     * {@inheritdoc}
     */
    public function max($selector = null);

    /**
     * {@inheritdoc}
     */
    public function min($selector = null);

    /**
     * {@inheritdoc}
     */
    public function sum($selector = null);

    /**
     * {@inheritdoc}
     */
    public function all($predicate);

    /**
     * {@inheritdoc}
     */
    public function any($predicate = null);

    /**
     * {@inheritdoc}
     */
    public function contains($value);

    /**
     * {@inheritdoc}
     */
    public function distinct($keySelector = null);

    /**
     * {@inheritdoc}
     */
    public function except($other, $keySelector = null);

    /**
     * {@inheritdoc}
     */
    public function intersect($other, $keySelector = null);

    /**
     * {@inheritdoc}
     */
    public function union($other, $keySelector = null);

    /**
     * {@inheritdoc}
     */
    public function elementAt($key);

    /**
     * {@inheritdoc}
     */
    public function elementAtOrDefault($key, $default = null);

    /**
     * {@inheritdoc}
     */
    public function first($predicate = null);

    /**
     * {@inheritdoc}
     */
    public function firstOrDefault($default = null, $predicate = null);

    /**
     * {@inheritdoc}
     */
    public function firstOrFallback($fallback, $predicate = null);

    /**
     * {@inheritdoc}
     */
    public function last($predicate = null);

    /**
     * {@inheritdoc}
     */
    public function lastOrDefault($default = null, $predicate = null);

    /**
     * {@inheritdoc}
     */
    public function lastOrFallback($fallback, $predicate = null);

    /**
     * {@inheritdoc}
     */
    public function single($predicate = null);

    /**
     * {@inheritdoc}
     */
    public function singleOrDefault($default = null, $predicate = null);

    /**
     * {@inheritdoc}
     */
    public function singleOrFallback($fallback, $predicate = null);

    /**
     * {@inheritdoc}
     */
    public function indexOf($value);

    /**
     * {@inheritdoc}
     */
    public function lastIndexOf($value);

    /**
     * {@inheritdoc}
     */
    public function findIndex($predicate);

    /**
     * {@inheritdoc}
     */
    public function findLastIndex($predicate);

    /**
     * {@inheritdoc}
     */
    public function skip($count);

    /**
     * {@inheritdoc}
     */
    public function skipWhile($predicate);

    /**
     * {@inheritdoc}
     */
    public function take($count);

    /**
     * {@inheritdoc}
     */
    public function takeWhile($predicate);

    /**
     * {@inheritdoc}
     */
    public function toArray();

    /**
     * {@inheritdoc}
     */
    public function toArrayDeep();

    /**
     * {@inheritdoc}
     */
    public function toList();

    /**
     * {@inheritdoc}
     */
    public function toListDeep();

    /**
     * {@inheritdoc}
     */
    public function toDictionary($keySelector = null, $valueSelector = null);

    /**
     * {@inheritdoc}
     */
    public function toJSON($options = 0);

    /**
     * {@inheritdoc}
     */
    public function toLookup($keySelector = null, $valueSelector = null);

    /**
     * {@inheritdoc}
     */
    public function toKeys();

    /**
     * {@inheritdoc}
     */
    public function toValues();

    /**
     * {@inheritdoc}
     */
    public function toString($separator = '', $valueSelector = null);

    /**
     * {@inheritdoc}
     */
    public function each($action = null);
}
