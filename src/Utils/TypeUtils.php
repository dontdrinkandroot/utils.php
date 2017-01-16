<?php

namespace Dontdrinkandroot\Utils;

class TypeUtils
{
    /**
     * Asserts that the input is an integerish, otherwise null will be returned.
     *
     * @param mixed $value The input value.
     *
     * @return integer|null
     */
    public static function integerOrNull($value): ?int
    {
        $intVal = intval($value);
        if (is_object($value)
            || strval($intVal) != $value
            || is_bool($value)
            || is_null($value)
        ) {
            return null;
        }

        return $intVal;
    }

    /**
     * @param int|float $num1
     * @param int|float $num2
     *
     * @return int
     */
    public static function compareNumbers($num1, $num2): ?int
    {
        if ($num1 == $num2) {
            return 0;
        }

        return ($num1 < $num2) ? -1 : 1;
    }
}
