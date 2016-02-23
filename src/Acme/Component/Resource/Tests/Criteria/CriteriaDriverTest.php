<?php

namespace Acme\Component\Resource\Tests\Criteria;

use Acme\Component\Resource\Criteria\MetadataDriverInterface;
use Acme\Component\Hotel\Model\Room;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CriteriaDriverTest extends KernelTestCase
{
    /**
     * @var MetadataDriverInterface
     */
    protected $driver;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        self::bootKernel();
        $this->driver = static::$kernel->getContainer()->get('acme.driver.criteria');
    }

    public function testSearchMapping()
    {
        $this->assertGreaterThan(0, count($this->driver->getSearchKeys(Room::class)));
    }

    public function testFiltersMapping()
    {
        $this->assertGreaterThan(0, count($this->driver->getFilterKeys(Room::class)));
    }

    public function testSortsMapping()
    {
        $this->assertGreaterThan(0, count($this->driver->getSortKeys(Room::class)));
    }
}
