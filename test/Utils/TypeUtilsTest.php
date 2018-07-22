<?php

namespace Dontdrinkandroot\Utils;

use PHPUnit\Framework\TestCase;

class TypeUtilsTest extends TestCase
{
    public function testIntegerOrNull()
    {
        $this->assertNull(TypeUtils::integerOrNull(''));
        $this->assertNull(TypeUtils::integerOrNull('1.2'));
        $this->assertNull(TypeUtils::integerOrNull('bla'));
        $this->assertNull(TypeUtils::integerOrNull(null));
        $this->assertNull(TypeUtils::integerOrNull([]));
        $this->assertNull(TypeUtils::integerOrNull(['b', 'la']));
        $this->assertNull(TypeUtils::integerOrNull(true));
        $this->assertNull(TypeUtils::integerOrNull(false));

        $this->assertEquals(0, TypeUtils::integerOrNull(0));
        $this->assertEquals(0, TypeUtils::integerOrNull(""));

        $this->assertEquals(1, TypeUtils::integerOrNull(1));
        $this->assertEquals(1, TypeUtils::integerOrNull("1"));
    }
}
