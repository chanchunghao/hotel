<?php

namespace Acme\Component\Common\Pagination;

use Acme\Component\Common\Collection\Enumerable;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Pagerfanta;

abstract class AbstractPaginator implements PaginatorInterface
{
    /**
     * @var Pagerfanta
     */
    protected $paginator;
    
    /**
     * @param mixed $source
     */
    public function __construct($source)
    {
        $this->paginator = new Pagerfanta($this->getAdapter($source));
    }

    /**
     * {@inheritdoc}
     */
    public function getPageSize()
    {
        return $this->paginator->getMaxPerPage();
    }

    /**
     * {@inheritdoc}
     */
    public function setPageSize($size)
    {
        $this->paginator->setMaxPerPage($size);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageIndex()
    {
        return $this->paginator->getCurrentPage();
    }

    /**
     * {@inheritdoc}
     */
    public function setPageIndex($page)
    {
        $this->paginator->setCurrentPage($page);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentPage()
    {
        $results = $this->paginator->getCurrentPageResults();

        return $results ? Enumerable::from($results)->toArray() : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageCount()
    {
        return $this->paginator->getNbPages();
    }

    /**
     * {@inheritdoc}
     */
    public function getTotal()
    {
        return $this->paginator->getNbResults();
    }

    /**
     * {@inheritdoc}
     */
    public function hasNextPage()
    {
        return $this->paginator->hasNextPage();
    }

    /**
     * {@inheritdoc}
     */
    public function hasPreviousPage()
    {
        return $this->paginator->hasPreviousPage();
    }

    /**
     * @param mixed $source
     * @return AdapterInterface
     */
    abstract protected function getAdapter($source);
}
