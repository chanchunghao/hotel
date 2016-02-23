<?php

namespace Acme\Component\Resource\Tests\Criteria;

use Acme\Component\Resource\Criteria\SearchCriteria;

class SearchCriteriaTest extends \PHPUnit_Framework_TestCase
{
    public function testSorter()
    {
        $criteria = $this
            ->getMockBuilder('Acme\Component\Resource\Criteria\SearchCriteria')
            ->setMethods(['__construct', 'getAllSortKeys'])
            ->disableOriginalConstructor()
            ->getMock();
        $criteria
            ->method('getAllSortKeys')
            ->willReturn(['foo', 'bar', 'fooBar']);

        /** @var SearchCriteria $criteria */
        $sorts = $criteria->getAllSortKeys();
        $index = rand(0, count($sorts) - 1);
        $expectedOrderBy = $sorts[$index];

        $criteria->addSorter($expectedOrderBy);
        $this->assertTrue(array_key_exists($expectedOrderBy, $criteria->getSorters()));

        $criteria->addSorter($index);
        $this->assertTrue(array_key_exists($expectedOrderBy, $criteria->getSorters()));

        $criteria->addSorter($expectedOrderBy, 'ASC');
        $this->assertEquals($criteria->getSorters()[$expectedOrderBy], 'ASC');

        $criteria->addSorter($expectedOrderBy, 'DESC');
        $this->assertEquals($criteria->getSorters()[$expectedOrderBy], 'DESC');

        $criteria->addSorter($expectedOrderBy, true);
        $this->assertEquals($criteria->getSorters()[$expectedOrderBy], 'ASC');

        $criteria->addSorter($expectedOrderBy, false);
        $this->assertEquals($criteria->getSorters()[$expectedOrderBy], 'DESC');

        $criteria->addSorter($expectedOrderBy, 1);
        $this->assertEquals($criteria->getSorters()[$expectedOrderBy], 'ASC');

        $criteria->addSorter($expectedOrderBy, 0);
        $this->assertEquals($criteria->getSorters()[$expectedOrderBy], 'DESC');

        $criteria->addSorter($expectedOrderBy, 'true');
        $this->assertEquals($criteria->getSorters()[$expectedOrderBy], 'ASC');

        $criteria->addSorter($expectedOrderBy, 'false');
        $this->assertEquals($criteria->getSorters()[$expectedOrderBy], 'DESC');

        $criteria->addSorter($expectedOrderBy, 'True');
        $this->assertEquals($criteria->getSorters()[$expectedOrderBy], 'ASC');

        $criteria->addSorter($expectedOrderBy, 'False');
        $this->assertEquals($criteria->getSorters()[$expectedOrderBy], 'DESC');
    }
}
