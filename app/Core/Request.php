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

  // Returns all uploaded files
  public function files(): array
  {
    return $_FILES;
  }

  // Returns specific file input data based on the input name
  public function file($key = null)
  {
    if (is_null($key)) {
      return $this->files();
    }

    return $this->files()[$key] ?? null;
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
    // Check for common API prefixes
    $isApiPath = strpos($_SERVER["REQUEST_URI"], "/api/") === 0;

    // Check for specific HTTP methods often used in APIs
    $validMethods = ["GET", "POST", "PUT", "DELETE", "PATCH"];
    $isApiMethod = in_array($_SERVER["REQUEST_METHOD"], $validMethods);

    // Check for content type for JSON requests, which is common in APIs
    $isJsonRequest =
      isset($_SERVER["CONTENT_TYPE"]) &&
      strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false;

    // Check for API key in headers
    $apiKeyPresent = isset($_SERVER["HTTP_API_KEY"]);
    $validApiKey =
      $apiKeyPresent && $_SERVER["HTTP_API_KEY"] === "your_api_key_here";

    // Optionally, check the request origin if necessary
    $isCORS =
      isset($_SERVER["HTTP_ORIGIN"]) &&
      $_SERVER["HTTP_ORIGIN"] === "trusted_origin_here";

    // Combine the checks to determine if it's an API request
    return ($isApiPath && $isApiMethod) ||
      ($validApiKey && $isJsonRequest) ||
      $isCORS;
  }
}
