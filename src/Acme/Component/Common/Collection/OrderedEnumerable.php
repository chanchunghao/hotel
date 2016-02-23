<?php

namespace Acme\Component\Common\Collection;

use YaLinqo\OrderedEnumerable as OrderedEnumerableBase;

class OrderedEnumerable extends Enumerable implements OrderedEnumerableInterface
{
    /**
     * @var OrderedEnumerableBase $enumerable
     */
    protected $enumerable;

    /**
     * @internal
     * @param OrderedEnumerableBase $enumerable
     */
    public function __construct(OrderedEnumerableBase $enumerable)
    {
        $this->enumerable = $enumerable;
    }

    /**
     * {@inheritdoc}
     */
    public function thenBy($keySelector = null, $comparer = null)
    {
        return new self($this->enumerable->thenBy($keySelector, $comparer));
    }

    /**
     * {@inheritdoc}
     */
    public function thenByDescending($keySelector = null, $comparer = null)
    {
        return new self($this->enumerable->thenByDescending($keySelector, $comparer));
    }
}
