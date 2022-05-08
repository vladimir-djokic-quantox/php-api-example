<?php

namespace PhpApi\Db\Person;

use \PDO;
use \PDOException;
use PhpApi\Db\DbConnector;

class PersonRepository {
    public static function getAll() {
        $sql = "SELECT id, first_name, last_name FROM person";

        try {
            $query = DbConnector::getConnection()->query($sql);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            return array_map(
                function ($r) {
                    return new Person(
                        intval($r["id"]),
                        $r["first_name"],
                        $r["last_name"]
                    );
                },
                $result
            );
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function getById(int $id) {
        $sql = "SELECT id, first_name, last_name FROM person WHERE id = ?";

        try {
            $query = DbConnector::getConnection()->prepare($sql);
            $query->execute([$id]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            return new Person(
                intval($result[0]["id"]),
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
            $connection = DbConnector::getConnection();

            $query = $connection->prepare($sql);
            $query->execute([
                "first_name" => $payload->firstName,
                "last_name" => $payload->lastName
            ]);
            
            return new Person(
                $connection->lastInsertId(),
                $payload->firstName,
                $payload->lastName
            );
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function update(Person $person) {
        $sql = "UPDATE person SET first_name = :first_name, last_name = :last_name WHERE id = :id";

        try {
            $query = DbConnector::getConnection()->prepare($sql);
            $query->execute([
                "id" => $person->id,
                "first_name" => $person->firstName,
                "last_name" => $person->lastName
            ]);

            return $person;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function delete(int $id) {
        $sql = "DELETE FROM person WHERE id = :id";

        try {
            $query = DbConnector::getConnection()->prepare($sql);
            $query->execute(["id" => $id]);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}