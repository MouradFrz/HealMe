<?php

use App\Routing\Router;
use App\Controllers\HomeController;
$router = new Router();

$router->get('/',[HomeController::class,'index']);
$router->get('/404',[HomeController::class,'Error404']);
$router->get('/401',[HomeController::class,'Error401']);
$router->get('/403',[HomeController::class,'Error403']);
$router->get('/login',[HomeController::class,'login']);
$router->get('/register',[HomeController::class,'register']);
try {
    $router->route();
} catch (Exception $e) {
}