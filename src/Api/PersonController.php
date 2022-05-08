<?php

namespace PhpApi\Api;

use PhpApi\Db\Person\PersonRepository;

class PersonController {
    public function exec($requestMethod, $personId) {
        switch ($requestMethod) {
            case "GET":
                if ($personId)
                    $this->getByIdResponse($personId);
                else
                    $this->getAllResponse();
                break;

            default:
                $this->notFoundResponse();
        }
    }

    private function getByIdResponse($personId) {
        $person = PersonRepository::getById($personId);

        header("HTTP/1.1 200 OK");
        echo json_encode($person);
    }

    private function getAllResponse() {
        $all = PersonRepository::getAll();

        header("HTTP/1.1 200 OK");
        echo json_encode($all);
    }

    private function notFoundResponse() {
        header("HTTP/1.1 404 Not Found");
    }
}