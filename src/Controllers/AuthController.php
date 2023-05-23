<?php

namespace App\Controllers;

use App\Database\NoSql;

class AuthController
{
    public static function check()
    {
        $email = $_POST['email'];
        $password = $_POST["password"];
        $nosql = new NoSql();
        $collection = $nosql->getUsersCollection();
        $data = $collection->find(["email" => $email, "password" => $password])->toArray();
        echo count($data);
        if (count($data)) {
            $_SESSION['user'] = $email;
            redirect('/');
        } else {
            loadSession(["error" => "Invalid credentials"]);
            redirect('/login');
        }
    }
}
