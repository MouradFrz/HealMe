<?php

namespace App\Controllers;

use App\Database\NoSql;
use Exception;

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
                "_id" => false,
            ]]
        )->toArray();
        loadSession(["userData" => $data[0]]);
        require_once '../src/Views/book.php';
    }
    public static function getAppointments()
    {
        header('Content-Type: application/json; charset=UTF-8');
        $nosql = new NoSql();
        $date = $_GET['date'];
        try {
            $collection = $nosql->getAppointmentsCollection();
            $data = $collection->find(["date" => $date], ["projection" => ["_id" => false, "time" => true]])->toArray();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        echo json_encode($data);
    }
}
