<?php

namespace Almhdy\Simy\Core;

class Router
{
  // private array $routes = [];
  public array $routes = [];
  public array $params = [];

  // Define a route for GET HTTP method with optional middleware
  public function get(string $uri, mixed $handler, array $middlewares = [])
  {
    $this->addRoute("GET", $uri, $handler, $middlewares);
  }

  // Define a route for POST HTTP method with optional middleware
  public function post(string $uri, mixed $handler, array $middlewares = [])
  {
    $this->addRoute("POST", $uri, $handler, $middlewares);
  }

  // Define a route for PUT HTTP method with optional middleware
  public function put(string $uri, mixed $handler, array $middlewares = [])
  {
    $this->addRoute("PUT", $uri, $handler, $middlewares);
  }

  // Define a route for DELETE HTTP method with optional middleware
  public function delete(string $uri, mixed $handler, array $middlewares = [])
  {
    $this->addRoute("DELETE", $uri, $handler, $middlewares);
  }

  // Create a new route with the HTTP method, URI and handler
  private function addRoute(string $httpMethod, string $uri, mixed $handler)
  {
    $this->routes[$httpMethod][$uri] = [
      "handler" => $handler,
    ];
  }

  // Route the incoming request to the appropriate handler
  public function routeRequest(string $uri, string $httpMethod)
  {
    $handlerData = $this->findMatchingRoute($uri, $httpMethod);

    if ($handlerData) {
      $this->callHandler($handlerData["handler"]);
    } else {
      $this->handleNotFound();
    }
  }

  // Find the matching route for the given URI and HTTP method
  private function findMatchingRoute(string $uri, string $httpMethod): ?array
  {
    if (empty($this->routes[$httpMethod])) {
      return null;
    }
    foreach ($this->routes[$httpMethod] as $route => $data) {
      if ($this->isMatchingRoute($route, $uri)) {
        return $data;
      }
    }
    return null;
  }

  // Check if the provided URI matches the route pattern
  private function isMatchingRoute(string $route, string $uri): bool
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

    return true;
  }

  // Call the appropriate handler based on its type
  private function callHandler(mixed $handler)
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
      // If the handler is a controller and method, call the method on the controller
      [$controllerClass, $method] = $handler;
      $controller = new $controllerClass();
      call_user_func_array([$controller, $method], $this->params);
    } else {
      $this->handleNotFound();
    }
  }

  // Handle the case when no matching route is found
  private function handleNotFound()
  {
    http_response_code(404);
    require "../app/Views/errors/404.php";
  }
  public function addResource($resourceName, $handler)
  {
    $this->get("/$resourceName/{id}", [$handler, "show"]);
    $this->get("/$resourceName", [$handler, "index"]);
    $this->post("/$resourceName", [$handler, "store"]);
    $this->put("/$resourceName/{id}", [$handler, "update"]);
    $this->delete("/$resourceName/{id}", [$handler, "delete"]);
  }
  
}
