<?php

namespace Acme\Component\Resource\Criteria;

use Symfony\Component\Config\FileLocatorInterface;

class CriteriaFactory implements CriteriaFactoryInterface
{
    /**
     * @var FileLocatorInterface
     */
    protected $locator;

    /**
     * @var MetadataDriverInterface
     */
    protected $driver;

    public function __construct(FileLocatorInterface $locator, MetadataDriverInterface $driver)
    {
        $this->locator = $locator;
        $this->driver = $driver;
    }

    /**
     * {@inheritdoc}
     */
    public function get($entityClassName)
    {
        return new SearchCriteria($entityClassName, $this->driver);
    }

    /**
     * {@inheritdoc}
     */
    public function getDriver()
    {
        return $this->driver;
    }
}
