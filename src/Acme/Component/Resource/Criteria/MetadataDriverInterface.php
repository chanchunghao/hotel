<?php

namespace Acme\Component\Resource\Criteria;

interface MetadataDriverInterface
{
    /**
     * @param string $className
     * @return array
     */
    public function getMetadataForClass($className);

    /**
     * @param string $className
     * @return array
     */
    public function getSearchKeys($className);

    /**
     * @param string $className
     * @return array
     */
    public function getFilterKeys($className);

    /**
     * @param string $className
     * @return array
     */
    public function getSortKeys($className);

    /**
     * @param string $className
     * @param $key
     * @return bool
     */
    public function isSearchable($className, $key);

    /**
     * @param string $className
     * @param $key
     * @return bool
     */
    public function isFilterable($className, $key);

    /**
     * @param string $className
     * @param $key
     * @return bool
     */
    public function isSortable($className, $key);
}
