<?php

namespace Acme\Component\Resource\Manager;

use Acme\Component\Common\Pagination\PaginatorInterface;
use Acme\Component\Resource\Model\DomainObjectInterface;

interface ManagerInterface
{
    /**
     * New a resource.
     *
     * @param array $params
     * @return DomainObjectInterface
     */
    public function newInstance(array $params = []);

    /**
     * Create a resource.
     *
     * @param DomainObjectInterface|array $params
     * @param PersistentOptions $options
     * @return DomainObjectInterface
     */
    public function create($params, $options = null);

    /**
     * Update a resource.
     *
     * @param DomainObjectInterface|array $params
     * @param  PersistentOptions $options
     * @return DomainObjectInterface
     */
    public function update($params, $options = null);

    /**
     * Delete a resource.
     *
     * @param DomainObjectInterface|int $params
     * @param OperatingOptions $options
     */
    public function delete($params, $options = null);

    /**
     * Validate a resource.
     *
     * @param DomainObjectInterface|array $params
     * @param array $errors
     * @param ValidatingOptions $options
     * @return bool
     */
    public function validate($params, array &$errors = [], $options = null);

    /**
     * Get resource by key.
     *
     * @param array|int $filters
     * @param array $sorters
     * @return DomainObjectInterface
     */
    public function get($filters, array $sorters = []);

    /**
     * Get all resource.
     *
     * @param array $sorters
     * @return PaginatorInterface
     */
    public function getAll(array $sorters = []);

    /**
     * Get resources by criteria.
     *
     * @param array $filters
     * @param array $sorters
     * @return PaginatorInterface
     */
    public function getBy(array $filters, array $sorters = []);

    /**
     * Search resources.
     *
     * @param $keyword
     * @param array $filters
     * @param array $sorters
     * @return PaginatorInterface
     */
    public function search($keyword, array $filters = [], array $sorters = []);
}
