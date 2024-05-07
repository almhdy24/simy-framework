<?php

use Almhdy\Simy\Core\Router;
use Almhdy\Simy\Core\Request;
use Almhdy\Simy\Controllers\HomeController;
use Almhdy\Simy\Controllers\UserController;
use Almhdy\Simy\Controllers\AuthController;
use Almhdy\Simy\Middlewares\AuthMiddleware;
use Almhdy\Simy\Middlewares\LoggingMiddleware;

$router = new Router();

// Define the AuthMiddleware instance
$authMiddleware = new AuthMiddleware(new Request());
$router->get("/", [HomeController::class, "index"]);
$router->get("/phpinfo", [HomeController::class, "info"]);

// login and home route.
$router->get("/home", function () {
  echo "Home page";
});
$router->get("/login", function () {
  echo "Login page";
});

// Set middleware for all routes
// $router->middleware([new AuthMiddleware(), new LoggingMiddleware()]);
// (new ($router->middleware[0])())->process(new Request(), function () {
//   echo "223";
// });
$router->routeMiddleware("/home", [$authMiddleware]);
return $router;
