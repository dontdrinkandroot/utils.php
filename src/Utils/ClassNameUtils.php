<?php

namespace Dontdrinkandroot\Utils;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class ClassNameUtils
{
    public static function getShortName(string $className): string
    {
        $parts = explode("\\", $className);
        $lastPart = $parts[count($parts) - 1];

        return strtolower(preg_replace('~(?<=\\w)([A-Z])~', '_$1', $lastPart));
    }
}
