<?php

use App\Controllers\AuthController;
use App\Routing\Router;
use App\Controllers\HomeController;
$router = new Router();
$router->get('/',[HomeController::class,'index']);
$router->get('/404',[HomeController::class,'Error404']);
$router->get('/401',[HomeController::class,'Error401']);
$router->get('/403',[HomeController::class,'Error403']);
$router->get('/login',[HomeController::class,'login'],["guest","user"]);
$router->get('/register',[HomeController::class,'register'],["guest","user"]);
$router->post('/check',[AuthController::class,'check'],["guest","user"]);
$router->post('/user/create',[AuthController::class,'create'],["guest","user"]);
$router->get("/dashboard",[HomeController::class,'dashboard'],["auth","user"]);
$router->post('/logout',[AuthController::class,'logout'],["auth","user"]);
try {
    $router->route();
} catch (Exception $e) {
}