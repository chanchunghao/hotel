<?php

namespace Acme\Component\Resource\Criteria;

interface CriteriaFactoryInterface
{
    /**
     * @param string $entityClassName
     * @return AbstractSearchCriteria
     */
    public function get($entityClassName);

    /**
     * @return MetadataDriverInterface
     */
    public function getDriver();
}
