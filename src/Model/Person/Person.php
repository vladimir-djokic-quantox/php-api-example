<?php

namespace PhpApi\Model\Person;

class Person extends PersonPayload {
    public int $id;

    public function __construct(int $id, string $firstName, string $lastName) {
        parent::__construct($firstName, $lastName);
        $this->id = $id;
    }
}