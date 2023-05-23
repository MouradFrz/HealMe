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
        $data = $collection->find(["email" => $email])->toArray();
        var_dump($data);
        if (count($data)) {
            if (password_verify($password, $data[0]->password)) {
                $_SESSION['user'] = $email;
                redirect('/dashboard');
            }
        } else {
            loadSession(["error" => "Invalid credentials"]);
            redirect('/login');
        }
    }
    public static function create()
    {
        $email = $_POST['email'];
        $password = $_POST["password"];
        $passwordConfirm = $_POST["confirmpassword"];
        $fullname = $_POST["fullname"];
        $nosql = new NoSql();
        $collection = $nosql->getUsersCollection();
        if (strlen($fullname) == 0 || strlen($password) == 0 || strlen($passwordConfirm) == 0 || strlen($email) == 0) {
            loadSession(["error" => "All fields are required."]);
            redirect('/register');
        }
        if ($password !== $passwordConfirm) {
            loadSession(["error" => "Passwords don't match."]);
            redirect('/register');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            loadSession(["error" => "Invalid email."]);
            redirect('/register');
        }
        $collection->insertOne([
            "fullname" => $fullname,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
        ]);
        loadSession(["success" => "Registered successfully."]);
        redirect('/register');
    }
    public static function logout()
    {
        unset($_SESSION["user"]);
        redirect("/");
    }
}
