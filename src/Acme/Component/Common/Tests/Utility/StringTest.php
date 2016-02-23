<?php

namespace Acme\Component\Common\Tests\Utility;

use Acme\Component\Common\Utility\String;

class StringTest extends \PHPUnit_Framework_TestCase
{
    public function testAccord()
    {
        $this->assertEquals('no articles', String::accord(0, '%d articles', '%d article', 'no articles'));
        $this->assertEquals('1 article', String::accord(1, '%d articles', '%d article', 'no articles'));
        $this->assertEquals('2 articles', String::accord(2, '%d articles', '%d article', 'no articles'));
    }

    public function testJoin()
    {
        $this->assertEquals('foo, bar', String::join(', ', ['foo', 'bar']));
        $this->assertEquals('foo, bar', String::join(', ', ['foo', '', 'bar']));
        $this->assertEquals('foo, bar', String::join(', ', ['foo', null, 'bar']));
    }

    public function testFormat()
    {
        $this->assertEquals('Format string: foo, bar.', String::format('Format string: {0}, {1}.', 'foo', 'bar'));
        $this->assertEquals('Format string: foo, foo.', String::format('Format string: {0}, {0}.', 'foo'));
    }

    public function testStartsWith()
    {
        $this->assertTrue(String::startsWith('foo bar', 'foo'));
        $this->assertFalse(String::startsWith('foo bar', 'Foo'));
    }

    public function testEndsWith()
    {
        $this->assertTrue(String::endsWith('foo bar', 'bar'));
        $this->assertFalse(String::endsWith('foo bar', 'Bar'));
    }

    public function testIsIp()
    {
        $this->assertTrue(String::isIp('192.168.0.1'));
        $this->assertFalse(String::isIp('unit test'));
    }

    public function testIsEmail()
    {
        $this->assertTrue(String::isEmail('email@example.com'));
        $this->assertTrue(String::isEmail('email.email@example.com'));
        $this->assertTrue(String::isEmail('email_email@example.com'));

        $this->assertFalse(String::isEmail('ema(i)l@example.com'));
        $this->assertFalse(String::isEmail('email@example'));
        $this->assertFalse(String::isEmail('@example.com'));
        $this->assertFalse(String::isEmail('unit test'));
    }

    public function testIsUrl()
    {
        $this->assertTrue(String::isUrl('http://example.com'));
        $this->assertTrue(String::isUrl('https://example.com'));

        $this->assertFalse(String::isUrl('example.com'));
        $this->assertFalse(String::isUrl('unit test'));
    }

    public function testContains()
    {
        $this->assertTrue(String::contains('foobar', 'oob'));
        $this->assertTrue(String::contains('foobar', ['foo', 'bar']));
        $this->assertTrue(String::contains(['foo', 'bar'], 'foo'));
        $this->assertTrue(String::contains('FOOBAR', 'foobar', false));
        $this->assertTrue(String::contains('foofoo', ['foo', 'bar'], false, false));

        $this->assertFalse(String::contains('FOOBAR', 'foobar', true));
        $this->assertFalse(String::contains('foofoo', ['foo', 'bar'], false, true));
    }

    public function testBaseClass()
    {
        $this->assertEquals('String', String::baseClass('Acme\Component\Common\Utility\String'));
    }

    public function testIsNullOrEmpty()
    {
        $this->assertTrue(String::isNullOrEmpty(null));
        $this->assertTrue(String::isNullOrEmpty(''));

        $this->assertFalse(String::isNullOrEmpty('1'));
        $this->assertFalse(String::isNullOrEmpty('   '));
        $this->assertFalse(String::isNullOrEmpty(1));
        $this->assertFalse(String::isNullOrEmpty(true));
    }

    public function testIsNullOrWhitespace()
    {
        $this->assertTrue(String::isNullOrWhitespace(null));
        $this->assertTrue(String::isNullOrWhitespace(''));
        $this->assertTrue(String::isNullOrWhitespace('   '));

        $this->assertFalse(String::isNullOrWhitespace('1'));
        $this->assertFalse(String::isNullOrWhitespace(1));
        $this->assertFalse(String::isNullOrWhitespace(true));
    }
}
