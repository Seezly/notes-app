<?php

namespace Core;

class Validator
{
    public static function string($value, $min = 0, $max = PHP_INT_MAX)
    {
        if (!is_string($value)) {
            return false;
        }

        $length = strlen($value);
        return $length >= $min && $length <= $max;
    }

    public static function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
