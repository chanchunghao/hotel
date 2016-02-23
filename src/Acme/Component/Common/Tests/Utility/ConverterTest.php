<?php

namespace Acme\Component\Common\Tests\Utility;

use Acme\Component\Common\Utility\Converter;

class ConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testToBoolean()
    {
        $this->assertTrue(Converter::toBoolean(true));
        $this->assertTrue(Converter::toBoolean(1));
        $this->assertTrue(Converter::toBoolean('true'));
        $this->assertTrue(Converter::toBoolean('True'));

        $this->assertFalse(Converter::toBoolean(false));
        $this->assertFalse(Converter::toBoolean(0));
        $this->assertFalse(Converter::toBoolean('false'));
        $this->assertFalse(Converter::toBoolean('False'));
        $this->assertFalse(Converter::toBoolean([]));
        $this->assertFalse(Converter::toBoolean(['foo', 'bar']));
    }

    public function testToInt()
    {
        $this->assertEquals(1, Converter::toInt(1));
        $this->assertEquals(1, Converter::toInt('1'));
        $this->assertEquals(1, Converter::toInt(true));
        $this->assertEquals(0, Converter::toInt(false));

        $this->assertFalse(Converter::toInt('1.1'));
        $this->assertFalse(Converter::toInt('1,000'));
        $this->assertFalse(Converter::toInt('1.000'));
        $this->assertFalse(Converter::toInt([]));
    }

    public function testToFloat()
    {
        $this->assertEquals(1.1, Converter::toFloat(1.1));
        $this->assertEquals(1.1, Converter::toFloat('1.1'));
        $this->assertEquals(1, Converter::toFloat(1));
        $this->assertEquals(1, Converter::toFloat('1'));
        $this->assertEquals(1, Converter::toFloat('1.000'));
        $this->assertEquals(1, Converter::toFloat(true));
        $this->assertEquals(0, Converter::toFloat(false));

        $this->assertFalse(Converter::toFloat('1,000'));
        $this->assertFalse(Converter::toFloat([]));
    }
}
