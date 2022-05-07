<?php

require_once "vendor/autoload.php";

use Dotenv\Dotenv;
use PhpApi\Db\DbConnector;

$dotenv = DotEnv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

$dbConnection = (new DbConnector())->getConnection();
