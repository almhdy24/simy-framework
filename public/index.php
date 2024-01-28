<?php
require_once "../vendor/autoload.php";
use Almhdy\Simy\Core\App;

$router = require_once "../app/Routes/Routes.php";
$app = new App($router);
$app->run();
