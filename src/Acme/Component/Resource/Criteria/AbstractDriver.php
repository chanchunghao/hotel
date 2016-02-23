<?php

namespace Acme\Component\Resource\Criteria;

use Symfony\Component\Config\FileLocatorInterface;

abstract class AbstractDriver implements MetadataDriverInterface
{
    /**
     * @var array
     */
    protected $mappings;

    /**
     * @var FileLocatorInterface
     */
    protected $locator;

    /**
     * @var string
     */
    protected $mappingPath;

    /**
     * @param FileLocatorInterface $locator
     * @param string $mappingPath
     */
    public function __construct(FileLocatorInterface $locator, $mappingPath)
    {
        $this->locator = $locator;
        $this->mappingPath = $locator->locate("$mappingPath");
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadataForClass($className)
    {
        $mappings = $this->getMappings();

        return array_key_exists($className, $mappings) ? $mappings[$className] : [];
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchKeys($className)
    {
        return $this->getMapping($className, 'searchBy');
    }

    /**
     * {@inheritdoc}
     */
    public function getFilterKeys($className)
    {
        return $this->getMapping($className, 'filterBy');
    }

    /**
     * {@inheritdoc}
     */
    public function getSortKeys($className)
    {
        return $this->getMapping($className, 'sortBy');
    }

    /**
     * {@inheritdoc}
     */
    public function isSearchable($className, $key)
    {
        return in_array($key, $this->getSearchKeys($className));
    }

    /**
     * {@inheritdoc}
     */
    public function isFilterable($className, $key)
    {
        return in_array($key, $this->getFilterKeys($className));
    }

    /**
     * {@inheritdoc}
     */
    public function isSortable($className, $key)
    {
        return in_array($key, $this->getSortKeys($className));
    }

    /**
     * @param string $path
     * @return array
     */
    abstract protected function parseMappingFile($path);

    /**
     * @param string $className
     * @param string $mappingName
     * @return array
     */
    protected function getMapping($className, $mappingName)
    {
        $mappings = $this->getMetadataForClass($className);

        return array_key_exists($mappingName, $mappings) ? $mappings[$mappingName] : [];
    }

    /**
     * @return array
     */
    protected function getMappings()
    {
        return $this->mappings ?: ($this->mappings = $this->parseMappingFile($this->mappingPath));
    }
}
