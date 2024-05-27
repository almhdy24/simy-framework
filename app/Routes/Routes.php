<?php

use Almhdy\Simy\Core\Router;
use Almhdy\Simy\Core\Controller;
use Almhdy\Simy\Controllers\HomeController;
use Almhdy\Simy\Controllers\UserController;

$router = new Router();

// login and home route.
$router->get("/", function () {
  $data = ["message" => "Hello World"];
  (new Controller())->jsonResponse($data);
});
// users resource

$router->addResource("users", UserController::class);
return $router;
