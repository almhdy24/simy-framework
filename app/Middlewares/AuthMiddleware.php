<?php

namespace Almhdy\Simy\Middlewares;
use Almhdy\Simy\Core\Controller;

class AuthMiddleware extends \Almhdy\Simy\Core\Middleware
{
  public function handle(mixed $request, callable $handler): mixed
  {
    // Add your authentication logic here
    // You can modify the request or return a response based on your authentication checks

    // Example: Check if the user is authenticated
    if (!$this->authenticateUser($request)) {
      // Redirect to login page or return a forbidden response
      // Example:
      (new Controller)->view("errors/403");
      //header("Location: /login");
      exit();
    }

    // If user is authenticated, continue with the request handling
    return $handler($request);
  }

  private function authenticateUser(mixed $request): bool
  {
    // Your authentication logic here
    // Example: Check if the user is logged in

    // This is a placeholder, replace it with your actual authentication logic
    return false;
  }
}
