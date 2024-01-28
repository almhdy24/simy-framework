<?php

namespace Almhdy\Simy\Core;
use Almhdy\Simy\Core\Router;
use Almhdy\Simy\Core\Request;
use Dotenv\Dotenv;
use Almhdy\Simy\Core\ErrorHandler;

class App
{
	protected $router;
	protected $dotenv;
	public function __construct(Router $router)
	{
		$this->router = $router;
		// Load the .env file
		$this->loadEnv();
		// enable custom error handling
		ErrorHandler::enableErrorHandling();
	}

	public function run()
	{
		$uri = (new Request())->getUri();
		// Remove any query string parameters from the URI
		$uri = strtok($uri, "?");

		// Add a leading slash if it's missing
		if ($uri !== "/") {
			$uri = "/" . ltrim($uri, "/");
		}
		$httpMethod = $_SERVER["REQUEST_METHOD"];
		$this->router->routeRequest($uri, $httpMethod);
	}

	protected function loadEnv()
	{
		$dotenvPath = __DIR__ . "/../"; // Path to the directory containing the .env file
		$this->dotenv = Dotenv::createImmutable($dotenvPath);
		$this->dotenv->load();
	}
}
