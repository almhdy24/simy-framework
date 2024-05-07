<?php

namespace Almhdy\Simy\Core;

use UserHandler;
class Request
{
    public function user()
    {
        return new UserHandler(); // You can implement your user handling logic here
    }

    public function isLoggedIn(): bool
    {
        // Implement your authentication logic here
        return true; // Placeholder for demo, return true if user is logged in
    }

    public function all(): array
    {
        return array_merge($_GET, $_POST);
    }

    public function getUri(): string
    {
        if (!empty($_SERVER["REQUEST_URI"])) {
            return trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
        }
        return '/';
    }

    // Additional methods can be added as needed
}