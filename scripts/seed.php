<?php

require_once "src/bootstrap.php";

$sql = <<<EOS

DROP TABLE IF EXISTS person;

CREATE TABLE IF NOT EXISTS person (
	id INT NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO person (first_name, last_name) VALUES ('Joye', 'Pollicote');
INSERT INTO person (first_name, last_name) VALUES ('Alexio', 'Collens');
INSERT INTO person (first_name, last_name) VALUES ('Winny', 'Tarplee');
INSERT INTO person (first_name, last_name) VALUES ('Nessa', 'Bentson');
INSERT INTO person (first_name, last_name) VALUES ('Kailey', 'Dalston');
INSERT INTO person (first_name, last_name) VALUES ('Damian', 'Bunney');
INSERT INTO person (first_name, last_name) VALUES ('Tuck', 'Jeandin');
INSERT INTO person (first_name, last_name) VALUES ('Odella', 'Attride');
INSERT INTO person (first_name, last_name) VALUES ('Scarface', 'Calbert');
INSERT INTO person (first_name, last_name) VALUES ('Nadiya', 'Cruickshank');

EOS;

try {
	$dbConnection->exec($sql);
	echo "Seeding done!\n";
} catch (\PDOException $e) {
	exit($e->getMessage());
}