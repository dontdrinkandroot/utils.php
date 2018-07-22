<?php

namespace Dontdrinkandroot\Utils;

use Traversable;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class CollectionUtils
{
    /**
     * @param array|Traversable $collection
     * @param callable          $collectFunction
     *
     * @return array
     */
    public static function collect($collection, callable $collectFunction): array
    {
        $results = [];
        foreach ($collection as $element) {
            $results[] = call_user_func($collectFunction, $element);
        }

        return $results;
    }

    /**
     * @param array|Traversable $collection
     * @param string          $propertyName
     *
     * @return array
     */
    public static function collectProperty($collection, string $propertyName): array
    {
        $results = [];
        foreach ($collection as $element) {
            $results[] = $element->{$propertyName};
        }

        return $results;
    }
}
