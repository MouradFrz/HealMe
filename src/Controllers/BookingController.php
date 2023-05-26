<?php

namespace App\Controllers;

use App\Database\NoSql;

class BookingController
{
    public static function book()
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
        require_once '../src/Views/book.php';
    }
}
