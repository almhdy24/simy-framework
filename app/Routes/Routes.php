<?php

use Almhdy\Simy\Controllers\AuthController;
use Almhdy\Simy\Middleware\AuthMiddleware;

$router = new Almhdy\Simy\Core\Router();

$router->get("/register", [AuthController::class, "showRegisterForm"]);
$router->post("/register", [AuthController::class, "register"]);
$router->get("/login", [AuthController::class, "showLoginForm"]);
$router->post("login", [AuthController::class, "login"]);
$router->get("/logout", [AuthController::class, "logout"]);

$router->addMiddleware("/dashboard", "GET", [AuthMiddleware::class, "handle"]);
$router->get("/dashboard", function () {
  require "../app/Views/dashboard.php";
});
return $router;
