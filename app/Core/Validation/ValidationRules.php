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

    public static function regex($value, $pattern): bool
    {
        return preg_match($pattern, $value) === 1;
    }

    public static function uuid($value): bool
    {
        return preg_match('/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/', $value) === 1;
    }

    public static function confirmed($value, $confirmation): bool
    {
        return $value === $confirmation;
    }

    public static function beforeDate($value, $date): bool
    {
        return strtotime($value) < strtotime($date);
    }

    public static function afterDate($value, $date): bool
    {
        return strtotime($value) > strtotime($date);
    }

    public static function inArray($value, array $values): bool
    {
        return in_array($value, $values);
    }

    public static function json($value): bool
    {
        json_decode($value);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public static function file($value): bool
    {
        return is_file($value);
    }

    public static function image($value): bool
    {
        $imageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/svg+xml'];
        return in_array(mime_content_type($value), $imageTypes);
    }

    public static function maxFileSize($value, $maxSize): bool
    {
        return filesize($value) <= $maxSize;
    }

    public static function mimeType($value, $mimeType): bool
    {
        return mime_content_type($value) === $mimeType;
    }

    public static function digits($value, $length): bool
    {
        return is_numeric($value) && strlen((string)$value) === $length;
    }

    public static function digitsBetween($value, $min, $max): bool
    {
        $length = strlen((string)$value);
        return is_numeric($value) && $length >= $min && $length <= $max;
    }

    public static function startsWith($value, $prefix): bool
    {
        return strpos($value, $prefix) === 0;
    }

    public static function endsWith($value, $suffix): bool
    {
        return substr($value, -strlen($suffix)) === $suffix;
    }

    public static function timezone($value): bool
    {
        return in_array($value, timezone_identifiers_list());
    }

    public static function unique($value, $data, $field): bool
    {
        $values = array_column($data, $field);
        return count(array_keys($values, $value)) <= 1;
    }

    // Additional validation rules
    public static function ipv4($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    public static function ipv6($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    public static function lt($value, $otherValue): bool
    {
        return $value < $otherValue;
    }

    public static function lte($value, $otherValue): bool
    {
        return $value <= $otherValue;
    }

    public static function gt($value, $otherValue): bool
    {
        return $value > $otherValue;
    }

    public static function gte($value, $otherValue): bool
    {
        return $value >= $otherValue;
    }

    public static function same($value, $otherValue): bool
    {
        return $value === $otherValue;
    }

    public static function different($value, $otherValue): bool
    {
        return $value !== $otherValue;
    }

    public static function size($value, $size): bool
    {
        return strlen($value) === $size;
    }

    public static function multipleOf($value, $multiple): bool
    {
        return $value % $multiple === 0;
    }

    public static function between($value, $min, $max): bool
    {
        return $value >= $min && $value <= $max;
    }

    public static function maxItems($value, $max): bool
    {
        return is_array($value) && count($value) <= $max;
    }

    public static function minItems($value, $min): bool
    {
        return is_array($value) && count($value) >= $min;
    }

    public static function contains($value, $substring): bool
    {
        return strpos($value, $substring) !== false;
    }

    public static function notContains($value, $substring): bool
    {
        return strpos($value, $substring) === false;
    }
}