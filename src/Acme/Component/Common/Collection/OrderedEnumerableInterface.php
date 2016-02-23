<?php

namespace Acme\Component\Common\Collection;

interface OrderedEnumerableInterface extends EnumerableInterface
{
    /**
     * {@inheritdoc}
     */
    public function thenBy($keySelector = null, $comparer = null);

    /**
     * {@inheritdoc}
     */
    public function thenByDescending($keySelector = null, $comparer = null);
}
