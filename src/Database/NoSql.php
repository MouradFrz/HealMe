<?php

namespace App\Database;
use MongoDB\Client;

class NoSql{
    private $cluster;

    function __construct()
    {
        $this->cluster = new Client($_ENV["MONGO_CONNECTION_STRING"]);
    }
    public function getUsersCollection(){
        return $this->cluster->HealMe->users;
    }
}