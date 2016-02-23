<?php

namespace Acme\Component\Common\Tests\Utility;

use Acme\Component\Common\Utility\Inflector;

class InflectorTest extends \PHPUnit_Framework_TestCase
{
    public function testTableize()
    {
        $this->assertEquals('model_name', Inflector::tableize('ModelName'));
        $this->assertEquals('model_name', Inflector::tableize('modelName'));
        $this->assertEquals('model_name', Inflector::tableize('model_name'));
    }

    public function testClassify()
    {
        $this->assertEquals('TableName', Inflector::classify('TableName'));
        $this->assertEquals('TableName', Inflector::classify('tableName'));
        $this->assertEquals('TableName', Inflector::classify('table_name'));
    }

    public function testCamelize()
    {
        $this->assertEquals('tableName', Inflector::camelize('TableName'));
        $this->assertEquals('tableName', Inflector::camelize('tableName'));
        $this->assertEquals('tableName', Inflector::camelize('table_name'));
    }

    public function testPluralize()
    {
        $this->assertEquals('books', Inflector::pluralize('book'));
        $this->assertEquals('cases', Inflector::pluralize('case'));
        $this->assertEquals('categories', Inflector::pluralize('category'));
        $this->assertEquals('children', Inflector::pluralize('child'));
        $this->assertEquals('criterion', Inflector::pluralize('criteria'));
        $this->assertEquals('people', Inflector::pluralize('person'));
    }

    public function testSingularize()
    {
        $this->assertEquals('book', Inflector::singularize('books'));
        $this->assertEquals('case', Inflector::singularize('cases'));
        $this->assertEquals('category', Inflector::singularize('categories'));
        $this->assertEquals('child', Inflector::singularize('children'));
        $this->assertEquals('criteria', Inflector::singularize('criterion'));
        $this->assertEquals('person', Inflector::singularize('people'));
    }
}
