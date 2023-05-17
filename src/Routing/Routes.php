<?php

use App\Routing\Router;
use App\Controllers\HomeController;
$router = new Router();

$router->get('/',[HomeController::class,'index']);

try {
    $router->route();
} catch (Exception $e) {
}