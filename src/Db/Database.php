<?php

namespace PhpApi\Db;

use \PDO;
use \PDOException;

class Database {
    private $connection;

    public function __construct() {
        $host = $_ENV["DB_HOST"];
        $port = $_ENV["DB_PORT"];
        $db = $_ENV["DB_NAME"];
        $user = $_ENV["DB_USERNAME"];
        $pass = $_ENV["DB_PASSWORD"];

        try {
            $this->connection = new PDO(
                "mysql:host=$host;port=$port;dbname=$db",
                $user,
                $pass
            );
        } catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}