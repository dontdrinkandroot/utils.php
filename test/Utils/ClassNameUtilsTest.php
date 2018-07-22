<?php

namespace Dontdrinkandroot\Utils;

use PHPUnit\Framework\TestCase;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class ClassNameUtilsTest extends TestCase
{
    public function testGetShortName()
    {
        $this->assertEquals('blog_post', ClassNameUtils::getShortName('App\Entity\BlogPost'));
        $this->assertEquals('user', ClassNameUtils::getShortName('User'));
    }
}
