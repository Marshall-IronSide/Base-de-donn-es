ALTER TABLE etudiants
    ADD telephone VARCHAR(20);

ALTER TABLE etudiants
    ADD sexe CHAR(1) NOT NULL;

ALTER TABLE etudiants
    ADD sexe CHAR(1) NOT NULL DEFAULT 'M';

ALTER TABLE etudiants
    ADD date_creation DATE DEFAULT CURRENT_DATE;

ALTER TABLE etudiants
    DROP
        telephone;

ALTER TABLE etudiants
    MODIFY sexe VARCHAR(10) NOT NULL;

ALTER TABLE etudiants
    MODIFY sexe VARCHAR(10);

ALTER TABLE etudiants
    MODIFY nom VARCHAR(100) NOT NULL;

DROP TABLE IF EXISTS inscriptions;

DESCRIBE etudiants;

SHOW TABLES;

ALTER TABLE etudiants
    ADD nationalite VARCHAR(50) NOT NULL;

ALTER TABLE etudiants
    DROP date_creation;

ALTER TABLE etudiants
    MODIFY email VARCHAR(150);

DROP TABLE formations;

