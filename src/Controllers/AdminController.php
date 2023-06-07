<?php

namespace App\Controllers;

use App\Database\NoSql;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectID;

class AdminController
{
    public static function authenticate()
    {
        require_once '../src/Views/admin/authenticate.php';
    }
    public static function check()
    {
        $token = $_POST["token"];
        $nosql = new NoSql();
        $tokensCollection = $nosql->getAdminTokensCollection();
        $data = $tokensCollection->find([], ["projection" => ["token" => true, "_id" => false]])->toArray();
        if (in_array($token, array_map(function ($element) {
            return $element["token"];
        }, $data))) {
            $_SESSION['admin'] = true;
            redirect('/admin/dashboard');
        }
        loadSession(["error" => "Invalid token"]);
        redirect('/authenticate');
    }
    public static function dashboard()
    {
        require_once '../src/Views/admin/dashboard.php';
    }
    public static function accessControl()
    {
        $nosql = new NoSql();
        $collection = $nosql->getAdminTokensCollection();
        $tokens = $collection->find([], ["projection" => ["token" => true, "generated_at" => true]])->toArray();
        loadSession(["tokens" => $tokens]);
        require_once '../src/Views/admin/access.php';
    }
    public static function generateToken()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 16; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        $nosql = new NoSql();
        $collection = $nosql->getAdminTokensCollection();
        $collection->insertOne([
            "token" => $randomString,
            "generated_at" => new UTCDateTime(),
        ]);
        loadSession(["success" => "Token generated successfully!"]);
        redirect('/admin/access-control');
    }
    public static function deleteToken()
    {
        $id = $_POST["id"];
        $nosql = new NoSql();
        $collection = $nosql->getAdminTokensCollection();
        $collection->deleteOne([
            "_id" => new ObjectID($id),
        ]);
        loadSession(["success" => "Token deleted successfully!"]);
        redirect('/admin/access-control');
    }
    public static function logout()
    {
        unset($_SESSION["admin"]);
        redirect('/authenticate');
    }
}
