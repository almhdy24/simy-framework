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
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_';
        $charactersLength = strlen($characters);
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomPassword;
    }

    // Function to check if a password needs rehashing
    public static function needsRehash(string $hash): bool
    {
        return password_needs_rehash($hash, PASSWORD_DEFAULT);
    }

    // Function to generate a password hash with options
    public static function hashWithOptions(string $password, array $options): string
    {
        return password_hash($password, PASSWORD_DEFAULT, $options);
    }

    // Function to validate password strength
    public static function validateStrength(string $password, int $minLength = 8): bool
    {
        if (strlen($password) < $minLength) {
            return false;
        }
        if (!preg_match('/[A-Z]/', $password)) {
            return false; // At least one uppercase letter
        }
        if (!preg_match('/[a-z]/', $password)) {
            return false; // At least one lowercase letter
        }
        if (!preg_match('/[0-9]/', $password)) {
            return false; // At least one digit
        }
        if (!preg_match('/[\W]/', $password)) {
            return false; // At least one special character
        }
        return true;
    }

    // Function to generate a password reset token
    public static function generateResetToken(): string
    {
        return bin2hex(random_bytes(16));
    }

    // Function to validate a password reset token
    public static function validateResetToken(string $token): bool
    {
        return ctype_xdigit($token) && strlen($token) === 32;
    }
}