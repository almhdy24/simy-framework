<?php
use Almhdy\Simy\Core\Router;
use Almhdy\Simy\Controllers\HomeController;


$router = new Router();

$router->get("/", [HomeController::class, "index"]);

return $router;
