<?php

namespace Almhdy\Simy\Core;

use Almhdy\Simy\Core\Router;
use Almhdy\Simy\Core\Request;
use Dotenv\Dotenv;
use Almhdy\Simy\Core\ErrorHandler;

class App
{
  protected $router; // Instance of Router for handling routes
  protected $dotenv; // Instance of Dotenv for loading environment variables
  protected $request; // Instance of Request for get URI

  /**
   * Constructor to initialize the App with a Router instance and load environment variables
   * @param Router $router The Router instance to use for routing
   */
  public function __construct(Router $router)
  {
    $this->request = new Request();
    $this->router = $router;
    // Load the .env file
    $this->loadEnv();
    // enable custom error handling
    ErrorHandler::enableErrorHandling();
  }

  /**
   * Run the application by routing the request to the appropriate controller and action
   */
  public function run()
  {
    $uri = $this->request->getUri();
    // Remove any query string parameters from the URI
    $uri = strtok($uri, "?");

    // Add a leading slash if it's missing
    if ($uri !== "/") {
      $uri = "/" . ltrim($uri, "/");
    }
    $httpMethod = $this->request->getMethod();
    $this->router->routeRequest($uri, $httpMethod);
  }

  /**
   * Load environment variables from the .env file
   */
  protected function loadEnv()
  {
    $dotenvPath = __DIR__ . "/../"; // Path to the directory containing the .env file
    $this->dotenv = Dotenv::createImmutable($dotenvPath);
    $this->dotenv->load();
  }
}
