<?php

namespace App\Controllers;

use App\Database\NoSql;
use Exception;

class HomeController
{
    public static function index()
    {
        try {
            $connection = new NoSql();
            $collection = $connection->getUsersCollection();
            $data = $collection->find([
                "name" => "Yaou Mourad"
            ])->toArray();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $data = json_decode(json_encode($data));

        require_once '../src/Views/home.php';
    }
    public static function Error404()
    {
        require_once '../src/Views/404.php';
    }
    public static function Error403()
    {
        require_once '../src/Views/403.php';
    }
    public static function Error401()
    {
        require_once '../src/Views/401.php';
    }
    public static function login()
    {
        require_once '../src/Views/login.php';
    }
    public static function register()
    {
        require_once '../src/Views/register.php';
    }
    public static function dashboard()
    {
        $nosql = new NoSql();
        $collection = $nosql->getUsersCollection();
        $data = $collection->find(
            ["email" => $_SESSION["user"]],
            ["projection" => [
                "fullname" => true,
                "email" => true,
                "_id"=>false,
            ]]
        )->toArray();
        loadSession(["userData" => $data[0]]);
        require_once '../src/Views/dashboard.php';
    }
}
