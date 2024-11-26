<?php

namespace Almhdy\Simy\Core;

class Router
{
  private array $routes = [
    "GET" => [],
    "POST" => [],
    "PUT" => [],
    "DELETE" => [],
  ];
  public array $params = [];
  public function get($uri, $handler)
  {
    $this->addRoute("GET", $uri, $handler);
  }

  public function post($uri, $handler)
  {
    $this->addRoute("POST", $uri, $handler);
  }

  public function put($uri, $handler)
  {
    $this->addRoute("PUT", $uri, $handler);
  }

  public function delete($uri, $handler)
  {
    $this->addRoute("DELETE", $uri, $handler);
  }

  // Method to add a route that can be accessed by multiple HTTP methods
  public function map($uri, $handler, $methods = ["GET"])
  {
    foreach ($methods as $method) {
      $this->addRoute($method, $uri, $handler);
    }
  }
  private function addRoute($httpMethod, $uri, $handler)
  {
    $this->routes[$httpMethod][$uri] = $handler;
  }

  public function routeRequest($uri, $httpMethod)
  {
    $handler = $this->findMatchingRoute($uri, $httpMethod);

    if ($handler) {
      $this->callHandler($handler);
    } else {
      $this->handleNotFound();
    }
  }

  private function findMatchingRoute($uri, $httpMethod)
  {
    foreach ($this->routes[$httpMethod] as $route => $handler) {
      if ($this->isMatchingRoute($route, $uri)) {
        return $handler;
      }
    }
    return null;
  }

  private function isMatchingRoute($route, $uri)
  {
    // Special handling for the root path
    if ($route === "/") {
      return $uri === "/";
    }

    $route = str_replace("/", "\/", $route); // Escape forward slashes

    // Convert route parameters to regular expression groups using preg_replace_callback
    $route = preg_replace_callback(
      "/\{(\w+)\}/",
      function ($matches) {
        return "(?P<" . $matches[1] . ">[^\/]+)";
      },
      $route
    );

    // Updated pattern with start and end delimiters and case-insensitive flag
    $pattern = "/^" . $route . '$/i';

    // Check if the URI matches the route pattern
    if (preg_match($pattern, $uri, $matches)) {
      // Remove the full match from the matches array
      array_shift($matches);

      // Set route parameters for later use using the named capture groups
      $this->params = array_intersect_key(
        $matches,
        array_flip(array_filter(array_keys($matches), "is_string"))
      );

      return true;
    }

    return false;
  }

  private function callHandler($handler)
  {
    if (is_callable($handler)) {
      // If the handler is a callable function, just call the function
      $handler();
    } elseif (
      is_array($handler) &&
      count($handler) == 2 &&
      class_exists($handler[0]) &&
      method_exists($handler[0], $handler[1])
    ) {
      // If the handler is an array representing a controller and method, call the method on the controller
      $controller = new ($handler[0])();
      $method = $handler[1];
      call_user_func_array([$controller, $method], $this->params);
    } else {
      // Invalid handler format
      $this->handleNotFound();
    }
  }
  private function handleNotFound()
  {
    http_response_code(404);
    require "../app/Views/errors/404.php";
  }
}
