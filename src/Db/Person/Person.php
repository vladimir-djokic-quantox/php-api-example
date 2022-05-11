<?php

namespace PhpApi\Db\Person;

class PersonPayload {
    public string $firstName;
    public string $lastName;

    public function __construct(string $firstName, string $lastName) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}

class Person extends PersonPayload {
    public $id;

    public function __construct(int $id, string $firstName, string $lastName) {
        parent::__construct($firstName, $lastName);
        $this->id = $id;
    }
}