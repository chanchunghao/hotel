<?php

namespace Acme\Component\Common\Pagination;

/**
 * Pagination interface strictly defines the methods -
 * paginator will use to populate the pagination data
 */
interface PaginatorInterface
{
    /**
     * @return int
     */
    public function getPageSize();

    /**
     * @param int $size
     * @return $this
     */
    public function setPageSize($size);

    /**
     * @return int
     */
    public function getPageIndex();

    /**
     * @param int $page
     * @return $this
     */
    public function setPageIndex($page);

    /**
     * @return bool
     */
    public function hasNextPage();

    /**
     * @return bool
     */
    public function hasPreviousPage();

    /**
     * @return mixed
     */
    public function getCurrentPage();

    /**
     * @return int
     */
    public function getPageCount();

    /**
     * @return int
     */
    public function getTotal();
}
