<?php

use Almhdy\Simy\Core\Router;
use Almhdy\Simy\Controllers\HomeController;
use Almhdy\Simy\Controllers\UserController;
use Almhdy\Simy\Controllers\AuthController;
$router = new Router();

$router->get("/", [HomeController::class, "index"]);
$router->get("/phpinfo", [HomeController::class, "info"]);
// auth routes
$router->get("/login", [AuthController::class, "login"]);
$router->post("/auth/login",[AuthController::class,"auth"]);
return $router;
