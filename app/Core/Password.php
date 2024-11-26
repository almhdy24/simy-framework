<?php

namespace Almhdy\Simy\Core;

class Password
{
  // Function to generate a password hash
  public static function hash(string $password): string
  {
    return password_hash($password, PASSWORD_DEFAULT);
  }

  // Function to verify a password against a hash
  public static function verify(string $password, string $hash): bool
  {
    return password_verify($password, $hash);
  }

  // Function to generate a random password
  public static function generateRandom(int $length = 10): string
  {
    $characters =
      '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_';
    $charactersLength = strlen($characters);
    $randomPassword = "";
    for ($i = 0; $i < $length; $i++) {
      $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomPassword;
  }
}
