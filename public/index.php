<?php

require_once "src/bootstrap.php";

use PhpApi\Db\Database;
use PhpApi\Api\PersonController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if ($uri[1] !== 'api') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

function execPersonController($requestMethod, $uri): void {
    $personId = null;
    
    if (is_numeric($uri[3]))
        $personId = intval($uri[3]);

    $db = new Database();
    $connection = $db->getConnection();

    $controller = new PersonController($connection);
    $controller->exec($requestMethod, $personId);
}

switch ($uri[2]) {
    case "person":
        execPersonController($requestMethod, $uri);
        break;

    default:
        header("HTTP/1.1 404 Not Found");
        exit();
}