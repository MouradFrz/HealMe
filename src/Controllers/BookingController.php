<?php

namespace App\Controllers;

use App\Database\NoSql;
use MongoDB\BSON\UTCDateTime;

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
    public static function createAppointment()
    {
        $date = $_POST["date"];
        $time = $_POST["time"];
        $name = $_POST["name"];
        $reason = $_POST["reason"];

        $nosql = new NoSql();
        $usersCollection = $nosql->getUsersCollection();
        $appCollection = $nosql->getAppointmentsCollection();

        $user = $usersCollection->find(
            ["email" => $_SESSION["user"]],
            ["projection" => [
                "fullname" => true,
                "email" => true,
            ]]
        )->toArray()[0];

        $existingApp = $appCollection->find(["date" => $date, "time" => $time])->toArray();
        if (count($existingApp)) {
            http_response_code(403);
            echo json_encode(["error" => "This appointment just got reserved! Please chose a different time or date."]);
            exit;
        }

        $appCollection->insertOne([
            "date" => $date,
            "time" => $time,
            "name" => $name,
            "reason" => $reason,
            "created_at" => new UTCDateTime(),
            "user" => $user
        ]);

        loadSession(["success" => "Appointment created successfully!"]);
        echo json_encode([
            "redirect" => "/dashboard",
        ]);
        exit;
    }
}
