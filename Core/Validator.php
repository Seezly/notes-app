<?php

namespace Core;

use function PHPSTORM_META\type;

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

    public static function equal($value, $compare)
    {
        if ($value !== $compare) {
            return false;
        }

        return true;
    }

    public static function date($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}
