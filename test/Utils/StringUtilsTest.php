<?php


namespace Dontdrinkandroot\Utils;

use PHPUnit\Framework\TestCase;

class StringUtilsTest extends TestCase
{
    public function testStartsWith()
    {
        $this->assertTrue(StringUtils::startsWith('bla', ''));
        $this->assertTrue(StringUtils::startsWith('bla', 'bl'));
        $this->assertfalse(StringUtils::startsWith('bla', 'la'));
    }

    public function testEndsWith()
    {
        $this->assertTrue(StringUtils::endsWith('bla', ''));
        $this->assertTrue(StringUtils::endsWith('bla', 'la'));
        $this->assertfalse(StringUtils::endsWith('bla', 'bl'));
    }

    public function testGetFirstChar()
    {
        $this->assertFalse(StringUtils::getFirstChar(''));
        $this->assertEquals('b', StringUtils::getFirstChar('bla'));
    }

    public function testGetLastChar()
    {
        $this->assertFalse(StringUtils::getLastChar(''));
        $this->assertEquals('a', StringUtils::getLastChar('bla'));
    }
}
