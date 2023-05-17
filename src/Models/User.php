<?php

namespace App\Models;

use App\Database\Connection;
use PDO;

class User
{
    
    public static function index(): array
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM carsales');
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
}
