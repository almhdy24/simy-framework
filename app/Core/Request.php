<?php

namespace Almhdy\Simy\Core;

class Request
{
    public function __construct()
    {
        // Initialize any necessary properties here
    }

    // Returns all input data (GET and POST)
    public function all(): array
    {
        return array_merge($_GET, $_POST);
    }

    // Returns the cleaned up URI
    public function getUri(): string
    {
        return trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) ?? "/", "/");
    }

    // Returns the HTTP method of the request
    public function getMethod(): string
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    // Returns specific input data based on key
    public function input($key = null)
    {
        $data = $this->all();
        return $key ? ($data[$key] ?? null) : $data;
    }

    // Checks if a specific key exists in the input data
    public function has($key): bool
    {
        return array_key_exists($key, $this->all());
    }

    // Filters input data to include only specified keys
    public function only(array $keys): array
    {
        return array_intersect_key($this->all(), array_flip($keys));
    }

    // Filters input data to exclude specified keys
    public function except(array $keys): array
    {
        return array_diff_key($this->all(), array_flip($keys));
    }

    // Returns all uploaded files
    public function files(): array
    {
        return $_FILES;
    }

    // Returns specific file input data based on the input name
    public function file($key = null)
    {
        return $key ? ($_FILES[$key] ?? null) : $_FILES;
    }

    // Determines if the request is an AJAX request
    public function ajax(): bool
    {
        return !empty($_SERVER["HTTP_X_REQUESTED_WITH"]) &&
            strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) === "xmlhttprequest";
    }

    // Determines if the request is an API request
    public function api(): bool
    {
        return strpos($this->getUri(), 'api/') === 0;
    }
}