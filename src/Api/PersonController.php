<?php

namespace PhpApi\Api;

use PhpApi\Db\Person\PersonRepository;
use PhpApi\Model\Person\Person;
use PhpApi\Model\Person\PersonPayload;

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
                    $this->getById($personId);
                else
                    $this->getAll();
                break;

            case "POST":
                $this->postCreate();
                break;

            case "PUT":
                $this->putUpdate($personId);
                break;

            case "DELETE":
                $this->delete($personId);
                break;

            default:
                $this->notFoundResponse();
        }
    }

    private function getAll(): void {
        $all = $this->repository->getAll();

        header("HTTP/1.1 200 OK");
        echo json_encode($all);
    }

    private function getById($personId): void {
        $person = $this->repository->getById($personId);

        header("HTTP/1.1 200 OK");
        echo json_encode($person);
    }

    private function postCreate(): void {
        $body = json_decode(file_get_contents('php://input'), TRUE);

        $person = $this->repository->insert(new PersonPayload(
            $body["first_name"],
            $body["last_name"]
        ));

        header("HTTP/1.1 200 OK");
        echo json_encode($person);
    }

    private function putUpdate($personId): void {
        $body = json_decode(file_get_contents('php://input'), TRUE);
        
        $person = $this->repository->update(new Person(
            $personId,
            $body["first_name"],
            $body["last_name"]
        ));

        header("HTTP/1.1 200 OK");
        echo json_encode($person);
    }

    private function delete($personId): void {
        $this->repository->delete($personId);
        header("HTTP/1.1 200 OK");
    }

    private function notFoundResponse(): void {
        header("HTTP/1.1 404 Not Found");
    }
}