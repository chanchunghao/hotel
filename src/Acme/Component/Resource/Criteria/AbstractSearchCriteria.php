<?php

namespace Acme\Component\Resource\Criteria;

abstract class AbstractSearchCriteria extends AbstractCriteria
{
    /**
     * @return array
     */
    abstract public function getAllSearchKeys();

    /**
     * @var string
     */
    protected $keyword;

    /**
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @param string $keyword
     * @return $this
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }
}
