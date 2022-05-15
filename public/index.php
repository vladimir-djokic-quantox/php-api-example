<?php

require_once "src/bootstrap.php";

use PhpApi\Db\Database;
use PhpApi\Api\PersonController;

function execPersonController($requestMethod, $uri): void {
    $personId = null;

    if (isset($uri[3]) && is_numeric($uri[3]))
        $personId = intval($uri[3]);

    $db = new Database();
    $connection = $db->getConnection();

    $controller = new PersonController($connection);
    $controller->exec($requestMethod, $personId);
}

const API_ROUTE_COMPONENT = "api";
const PERSON_ROUTE_COMPONENT = "person";

function headers(): void {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
}

function notFound(): void {
    header("HTTP/1.1 404 Not Found");
    exit();
}

function execController(): void {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri );

    if ($uri[1] !== API_ROUTE_COMPONENT)
        notFound();

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    switch ($uri[2]) {
        case PERSON_ROUTE_COMPONENT:
            headers();
            execPersonController($requestMethod, $uri);
            break;

        default:
            notFound();
    }
}

execController();
