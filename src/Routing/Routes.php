<?php

use App\Controllers\AuthController;
use App\Routing\Router;
use App\Controllers\HomeController;
$router = new Router();
$router->get('/',[HomeController::class,'index'],["auth","user"]);
$router->get('/404',[HomeController::class,'Error404']);
$router->get('/401',[HomeController::class,'Error401']);
$router->get('/403',[HomeController::class,'Error403']);
$router->get('/login',[HomeController::class,'login']);
$router->get('/register',[HomeController::class,'register']);
$router->post('/check',[AuthController::class,'check']);
$router->post('/user/create',[AuthController::class,'create']);
$router->get("/dashboard",[HomeController::class,'dashboard']);
try {
    $router->route();
} catch (Exception $e) {
}