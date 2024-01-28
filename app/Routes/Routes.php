<?php

use Almhdy\Simy\Core\Router;
use Almhdy\Simy\Controllers\HomeController;

$router = new Router();

$router->get("/", [HomeController::class, "index"]);
$router->get("/phpinfo", [HomeController::class, "info"]);

return $router;
