<?php
namespace Almhdy\Simy\Core\Validation;

class ValidationRules
{
  public static function required($value)
  {
    return !empty(trim($value));
  }

  public static function email($value)
  {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }

  public static function numeric($value)
  {
    return is_numeric($value);
  }

  public static function alpha($value)
  {
    return ctype_alpha($value);
  }

  public static function alphaNumeric($value)
  {
    return ctype_alnum($value);
  }

  public static function min($value, $min)
  {
    return strlen($value) >= $min;
  }

  public static function max($value, $max)
  {
    return strlen($value) <= $max;
  }


  public static function date($value)
  {
    return strtotime($value) !== false;
  }

  public static function url($value)
  {
    return filter_var($value, FILTER_VALIDATE_URL);
  }

  public static function string($value)
  {
    return is_string($value);
  }

  public static function object($value)
  {
    return is_object($value);
  }

  public static function array($value)
  {
    return is_array($value);
  }

  public static function notNull($value)
  {
    return $value !== null;
  }

  public static function ipAddress($value)
  {
    return filter_var($value, FILTER_VALIDATE_IP);
  }

  public static function boolean($value)
  {
    return filter_var(
      $value,
      FILTER_VALIDATE_BOOLEAN,
      FILTER_NULL_ON_FAILURE
    ) !== null;
  }
}
