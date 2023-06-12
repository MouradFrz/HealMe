<?php

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\BookingController;
use App\Routing\Router;
use App\Controllers\HomeController;

$router = new Router();
$router->get('/', [HomeController::class, 'index']);
$router->get('/404', [HomeController::class, 'Error404']);
$router->get('/401', [HomeController::class, 'Error401']);
$router->get('/403', [HomeController::class, 'Error403']);
$router->get('/login', [HomeController::class, 'login'], ["guest", "user"]);
$router->get('/register', [HomeController::class, 'register'], ["guest", "user"]);
$router->post('/check', [AuthController::class, 'check'], ["guest", "user"]);
$router->post('/user/create', [AuthController::class, 'create'], ["guest", "user"]);
$router->get("/dashboard", [HomeController::class, 'dashboard'], ["auth", "user"]);
$router->post('/logout', [AuthController::class, 'logout'], ["auth", "user"]);
$router->get("/book", [BookingController::class, 'book'], ["auth", "user"]);
$router->get("/getAppointments", [BookingController::class, 'getAppointments'], ["auth", "user"]);
$router->post('/createAppointment', [BookingController::class, 'createAppointment'], ["auth", "user"]);
$router->get('/authenticate', [AdminController::class, 'authenticate'], ["guest", "admin"]);
$router->post('/admin/check', [AdminController::class, 'check'], ["guest", "admin"]);
$router->get('/admin/dashboard', [AdminController::class, 'dashboard'], ["auth", "admin"]);
$router->get('/admin/access-control', [AdminController::class, 'accessControl'], ["auth", "admin"]);
$router->post('/admin/generate-token', [AdminController::class, 'generateToken'], ["auth", "admin"]);
$router->post('/admin/delete-token', [AdminController::class, 'deleteToken'], ["auth", "admin"]);
$router->post('/admin/logout', [AdminController::class, 'logout'], ["auth", "admin"]);
$router->get('/admin/appointments', [AdminController::class, 'appointments'], ["auth", "admin"]);
$router->get('/admin/appointments-list', [AdminController::class, 'getAppointmentsList'], ["auth", "admin"]);
$router->get('/admin/downtime-management', [AdminController::class, 'downtimeManagement'], ['auth', 'admin']);
$router->get('/admin/create-downtime', [AdminController::class, 'createDowntime'], ['auth', 'admin']);
$router->post('/admin/create-downtime', [AdminController::class, 'newDowntime'], ['auth', 'admin']);

try {
    $router->route();
} catch (Exception $e) {
}
