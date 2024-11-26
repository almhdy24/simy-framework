<?php
namespace Almhdy\Simy\Core;

use UserHandler;

class Request
{
  public function __construct()
  {
    // TODO ..
  }
  // Returns a new instance of UserHandler
  public function user()
  {
    return new UserHandler();
  }

  // Checks if the user is logged in
  public function isLoggedIn(): bool
  {
    // Placeholder implementation for demo
    return true;
  }

  // Returns all input data (GET and POST)
  public function all(): array
  {
    return array_merge($_GET, $_POST);
  }

  // Returns the cleaned up URI
  public function getUri(): string
  {
    if (!empty($_SERVER["REQUEST_URI"])) {
      return trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
    }
    return "/";
  }

  // Returns the HTTP method of the request
  public function getMethod(): string
  {
    return $_SERVER["REQUEST_METHOD"];
  }

  // Returns specific input data based on key
  public function input($key = null)
  {
    if (is_null($key)) {
      return $this->all();
    }

    return $this->all()[$key] ?? null;
  }

  // Checks if a specific key exists in the input data
  public function has($key): bool
  {
    $inputData = $this->all();
    return isset($inputData[$key]);
  }

  // Filters input data to include only specified keys
  public function only(array $keys): array
  {
    $inputData = $this->all();
    return array_intersect_key($inputData, array_flip($keys));
  }

  // Filters input data to exclude specified keys
  public function except(array $keys): array
  {
    $inputData = $this->all();
    return array_diff_key($inputData, array_flip($keys));
  }

  // Determines if the request is an AJAX request
  public function ajax(): bool
  {
    return !empty($_SERVER["HTTP_X_REQUESTED_WITH"]) &&
      strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) === "xmlhttprequest";
  }
  // Determines if the request is an API request
  public function api()
  {
    
  }
}
