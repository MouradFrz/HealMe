<?php

namespace App\Controllers;

use App\Models\User;

class HomeController{
    public static function index(){
        $userdata = User::index();
        require_once '../src/Views/home.php';
    }
}