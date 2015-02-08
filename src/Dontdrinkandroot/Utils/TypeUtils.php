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
    public static function integerOrNull($value)
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
}
