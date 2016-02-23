<?php

namespace Acme\Component\Common\Tests\Utility;

use Acme\Component\Common\Utility\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetValue()
    {
        $this->assertEquals(1, Collection::getValue('foo', ['foo' => 1, 'bar' => 2]));
        $this->assertEquals(1, Collection::getValue('foo', ['foo' => '', 'bar' => 2], 1));
        $this->assertEquals('', Collection::getValue('foo', ['foo' => '', 'bar' => 2], 1, false));
        $this->assertEquals(3, Collection::getValue('acme', ['foo' => 1, 'bar' => 2], 3));
    }
}
