<?php

namespace PhpApi\Api;

use PhpApi\Db\Person\PersonRepository;

class PersonController {
    private PersonRepository $repository;

    public function __construct($connection) {
        $this->repository = new PersonRepository($connection);
    }

    public function exec($requestMethod, $personId): void
    {
        switch ($requestMethod) {
            case "GET":
                if ($personId)
                    $this->getByIdResponse($personId);
                else
                    $this->getAllResponse();
                break;

            case "POST":
            case "PUT":
            case "DELETE":
                break;

            default:
                $this->notFoundResponse();
        }
    }

    private function getByIdResponse($personId): void {
        $person = $this->repository->getById($personId);

        header("HTTP/1.1 200 OK");
        echo json_encode($person);
    }

    private function getAllResponse(): void {
        $all = $this->repository->getAll();

        header("HTTP/1.1 200 OK");
        echo json_encode($all);
    }

    private function notFoundResponse(): void {
        header("HTTP/1.1 404 Not Found");
    }
}