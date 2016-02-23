<?php

namespace Acme\Component\Resource\Repository;

use Doctrine\Common\Persistence\ObjectRepository as RepositoryBaseInterface;
use Acme\Component\Common\Pagination\PaginatorInterface;

interface RepositoryInterface extends RepositoryBaseInterface
{
    /**
     * Create paginator from source.
     *
     * @param mixed $source
     * @return PaginatorInterface
     */
    public static function createPaginator($source);

    /**
     * Get all resources.
     *
     * @param array $sorters
     * @return mixed
     */
    public function getAll(array $sorters = []);

    /**
     * Get resources by filters.
     *
     * @param array $filters
     * @param array $sorters
     * @return mixed
     */
    public function getBy(array $filters, array $sorters = []);

    /**
     * Search resources.
     *
     * @param string $q
     * @param array $fields
     * @param array $filters
     * @param array $sorters
     * @return mixed
     */
    public function search($q, array $fields, array $filters = [], array $sorters = []);
}
