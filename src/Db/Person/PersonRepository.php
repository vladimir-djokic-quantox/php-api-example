<?php

namespace PhpApi\Db\Person;

use \PDO;
use \PDOException;
use PhpApi\Db\Database;

class PersonRepository {
    public static function getAll() {
        $sql = "SELECT person_id, first_name, last_name FROM person";

        try {
            $query = (new Database())->getConnection()->query($sql);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            return array_map(
                function ($r) {
                    return new Person(
                        intval($r["person_id"]),
                        $r["first_name"],
                        $r["last_name"]
                    );
                },
                $result
            );
        } catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }

    public static function getById(int $personId) {
        $sql = "SELECT person_id, first_name, last_name FROM person WHERE person_id = :person_id";

        try {
            $query = (new Database())->getConnection()->prepare($sql);
            $query->execute(["person_id" => $personId]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            return new Person(
                intval($result[0]["person_id"]),
                $result[0]["first_name"],
                $result[0]["last_name"]
            );
        } catch (PDOException $e) {
            exit($e->getMessage());
        }

    }

    public static function insert(PersonPayload $payload) {
        $sql = "INSERT INTO person (first_name, last_name) VALUES(:first_name, :last_name)";

        try {
            $dbConnection = (new Database())->getConnection();

            $query = $dbConnection->prepare($sql);
            $query->execute([
                "first_name" => $payload->firstName,
                "last_name" => $payload->lastName
            ]);
            
            return new Person(
                $dbConnection->lastInsertId(),
                $payload->firstName,
                $payload->lastName
            );
        } catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }

    public static function update(Person $person) {
        $sql = "UPDATE person SET first_name = :first_name, last_name = :last_name WHERE person_id = :person_id";

        try {
            $query = (new Database())->getConnection()->prepare($sql);
            $query->execute([
                "person_id" => $person->id,
                "first_name" => $person->firstName,
                "last_name" => $person->lastName
            ]);

            return $person;
        } catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }

    public static function delete(int $personId) {
        $sql = "DELETE FROM person WHERE person_id = :person_id";

        try {
            $query = (new Database())->getConnection()->prepare($sql);
            $query->execute(["person_id" => $personId]);
        } catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }
}