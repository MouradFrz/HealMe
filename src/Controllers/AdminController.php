<?php

namespace App\Controllers;

use App\Database\NoSql;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectID;

class AdminController
{
    private static function getLastWeekStats(): array
    {
        $nosql = new NoSql();
        $collection = $nosql->getAppointmentsCollection();
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime('-1 week'));
        $matchStage = [
            '$match' => [
                'date' => [
                    '$gte' => $startDate,
                    '$lt' => $endDate
                ]
            ]
        ];
        $groupStage = [
            '$group' => [
                '_id' => ['date' => '$date'],
                'count' => ['$sum' => 1]
            ]
        ];
        $sortStage = [
            '$sort' => ['date' => -1]
        ];
        $pipeline = [$matchStage, $groupStage, $sortStage];
        $options = [];
        $result = $collection->aggregate($pipeline, $options)->toArray();
        return $result;
    }
    private static function getCrenoStats(): array
    {
        $nosql = new NoSql();
        $collection = $nosql->getAppointmentsCollection();
        $pipeline = [
            [
                '$group' => [
                    '_id' => ['time' => '$time'],
                    'count' => ['$sum' => 1]
                ]
            ],
            [
                '$sort' => ['count' => 1]
            ]
        ];
        $options = [];
        $result = $collection->aggregate($pipeline, $options)->toArray();
        return $result;
    }
    private static function checkIfTimePassed(String $time): bool //returns false if the appointment time has already passed
    {
        $exploded = explode(":", $time);
        $currentHour = intval(date("H")) - 1;
        $currentMinutes = intval(date("i"));

        if ($currentHour < intval($exploded[0])) {
            return true;
        } elseif ($currentHour > intval($exploded[0])) {
            return false;
        } else {
            if ($currentMinutes < intval($exploded[1] + 19)) {
                return true;
            } else {
                return false;
            }
        }
    }
    public static function getCurrentAppointmentIndex(array $arr): int|null
    {
        $currentHour = intval(date("H"));
        $currentMinutes = intval(date("i"));
        foreach ($arr as $index => $element) {
            $exploded = explode(":", $element['time']);
            if (intval($exploded[0]) !== $currentHour) {
                continue;
            } else {
                if (intval($exploded[1]) < $currentMinutes) {
                    continue;
                } else {
                    return $index;
                }
            }
        }
        return null;
    }
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
        //Fetching stats for the charts
        $barStats = Self::getCrenoStats();
        $lineStats = Self::getLastWeekStats();
        //--------------------------------------------------
        $nosql = new NoSql();
        $collection = $nosql->getAppointmentsCollection();
        //Fetching todays appointments
        $todays = $collection->find(
            ["date" => date('Y-m-d')],
            ["projection" => ["time" => true, "name" => true, "user" => true]]
        )->toArray();
        //--------------------------------------------------
        //Fetching the last 100 appoitments then filtering them by date(Leaving last weeks appointments only)
        $last100 = $collection->find(
            [],
            [
                "projection" => ["time" => true, "name" => true, "date" => true],
                "limit" => 100,
            ]
        )->toArray();
        $lastWeeks = array_filter($last100, function ($element) {
            return
                date_create()->modify("-1 week")->format('Y-m-d') < $element["date"]
                && $element["date"] <= date_create()->format('Y-m-d');
        });
        //---------------------------------------------------------------
        $tempResult = array_filter($todays, function ($element) {
            return AdminController::checkIfTimePassed($element["time"]);
        });
        $result = [];
        foreach ($tempResult as $element) {
            array_push($result, $element);
        }
        $currentClient = "None";
        $nextClient = "None";
        if (isset($result[0])) {
            $currentClient = $result[0];
        }
        if (isset($result[1])) {
            $nextClient = $result[1];
        }
        loadSession([
            "todaysAppointments" => $todays,
            "todaysCount" =>  count($todays) - count($result) . "/" . count($todays),
            "currentClientName" => $currentClient,
            "nextClientName" => $nextClient,
            "lastWeeks" => count($lastWeeks),
            "barStats" => $barStats,
            "lineStats" => $lineStats,
        ]);
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
    public static function appointments()
    {
        require_once '../src/Views/admin/appointments.php';
    }
    public static function getAppointmentsList()
    {
        header('Content-Type: application/json; charset=UTF-8');
        $date = $_GET["date"];
        $nosql = new NoSql();
        $collection = $nosql->getAppointmentsCollection();
        $filter = [
            "date" => $date,
        ];
        $options = [
            "projection" => [
                "name" => true,
                'created_at' => true,
                "time" => true,
                "_id" => false
            ]
        ];
        $results = $collection->find($filter, $options)->toArray();
        $formattedResults = [];
        $todaysDate =  date_create("now")->format("Y-m-d");
        foreach ($results as $appointment) {
            $item = [];
            $item["name"] = $appointment["name"];
            $item["created_at"] = $appointment["created_at"]->toDateTime()->format("Y-m-d H:i");
            $item["time"] = $appointment["time"];
            if ($todaysDate == $date) {
                $item["status"] = Self::checkIfTimePassed($appointment["time"]) ? "Upcoming" : "Passed";
            } elseif ($todaysDate > $date) {
                $item["status"] = "Passed";
            } else {
                $item["status"] = "Upcoming";
            }
            array_push($formattedResults, $item);
        }
        echo json_encode($formattedResults);
    }
    public static function downtimeManagement()
    {
        $nosql = new NoSql();
        $collection = $nosql->getDowntimesCollection();
        $data = $collection->find([], [
            "projection" => [
                "startdate" => true,
                "enddate" => true,
                "_id" => false,
            ]
        ])->toArray();
        $todaysDate =  date_create("now")->format("Y-m-d");
        foreach ($data as $dt) {
            if ($dt["startdate"] > $todaysDate) {
                $dt["status"] = "Upcoming";
            } elseif ($dt["enddate"] < $todaysDate) {
                $dt["status"] = "Passed";
            } else {
                $dt["status"] = "Ongoing";
            }
        }
        loadSession(["downtimes" => $data]);
        require_once '../src/Views/admin/downtime.php';
    }
    public static function createDowntime()
    {
        require_once '../src/Views/admin/add-downtime.php';
    }
    public static function newDowntime()
    {
        $startDate = $_POST["startdate"];
        $endDate = $_POST["enddate"];
        if (!$startDate || !$endDate) {
            loadSession(["error" => "You need to specify a start and end date."]);
            redirect('/admin/create-downtime');
        }
        $nosql = new NoSql();
        $collection = $nosql->getDowntimesCollection();
        $collection->insertOne([
            "startdate" => $startDate,
            "enddate" => $endDate,
        ]);
        loadSession(["success" => "Downtime created successfully."]);
        redirect('/admin/downtime-management');
    }
}
