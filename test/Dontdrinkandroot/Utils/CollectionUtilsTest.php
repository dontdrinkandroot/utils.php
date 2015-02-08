<?php

namespace Dontdrinkandroot\Utils;

class CollectionUtilsTest extends \PHPUnit_Framework_TestCase
{

    public function testCollect()
    {
        $collection = [];
        $collection[] = new SimplePopo('a', 1);
        $collection[] = new SimplePopo('c', 3);
        $collection[] = new SimplePopo('b', 2);

        $result = CollectionUtils::collect(
            $collection,
            function (SimplePopo $simplePopo) {
                return $simplePopo->getProperty1();
            }
        );
        $this->assertEquals(['a', 'c', 'b'], $result);

        $result = CollectionUtils::collect(
            $collection,
            function (SimplePopo $simplePopo) {
                return $simplePopo->getProperty2();
            }
        );
        $this->assertEquals([1, 3, 2], $result);
    }

    public function testCollectProperty()
    {
        $collection = [];
        $collection[] = new SimplePopo('a', 1);
        $collection[] = new SimplePopo('c', 3);
        $collection[] = new SimplePopo('b', 2);

        $result = CollectionUtils::collectProperty($collection, 'property1');
        $this->assertEquals(['a', 'c', 'b'], $result);
    }
}