<?php

namespace Almhdy\Simy\Core\Validation;

class ValidationRules
{
    public static function required($value): bool
    {
        return !empty(trim($value));
    }

    public static function email($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function numeric($value): bool
    {
        return is_numeric($value);
    }

    public static function alpha($value): bool
    {
        return ctype_alpha($value);
    }

    public static function alphaNumeric($value): bool
    {
        return ctype_alnum($value);
    }

    public static function min($value, $min): bool
    {
        return strlen($value) >= $min;
    }

    public static function max($value, $max): bool
    {
        return strlen($value) <= $max;
    }

    public static function date($value): bool
    {
        return strtotime($value) !== false;
    }

    public static function url($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    public static function string($value): bool
    {
        return is_string($value);
    }

    public static function object($value): bool
    {
        return is_object($value);
    }

    public static function array($value): bool
    {
        return is_array($value);
    }

    public static function notNull($value): bool
    {
        return $value !== null;
    }

    public static function ipAddress($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }

    public static function boolean($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null;
    }
}