<?php

namespace PhpApi\Db;

use \PDO;
use \PDOException;

class DbConnector {
    private static ?PDO $connection = null;

    public static function getConnection() {
        if (DbConnector::$connection === null) {
            $host = $_ENV["DB_HOST"];
            $port = $_ENV["DB_PORT"];
            $db = $_ENV["DB_NAME"];
            $user = $_ENV["DB_USERNAME"];
            $pass = $_ENV["DB_PASSWORD"];

            try {
                return new PDO(
                    "mysql:host=$host;port=$port;dbname=$db",
                    $user,
                    $pass
                );
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        }

        return DbConnector::$connection;
    }
}