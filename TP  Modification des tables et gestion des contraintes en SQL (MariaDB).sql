CREATE DATABASE ecole_contraintes;
USE ecole_contraintes;
CREATE TABLE classe
(
    Page 2 sur 4
        id_classe INT PRIMARY KEY,
    libelle_classe VARCHAR(50)
);

CREATE TABLE etudiant
(
    id_etudiant INT PRIMARY KEY,
    nom         VARCHAR(50),
    prenom      VARCHAR(50),
    age         INT,
    email       VARCHAR(100),
    id_classe   INT
);

ALTER TABLE etudiant
    MODIFY nom VARCHAR(50) NOT NULL,
    MODIFY prenom VARCHAR(50) NOT NULL,
    MODIFY email VARCHAR(100) NOT NULL;

ALTER TABLE classe
    MODIFY libelle_classe VARCHAR(50) NOT NULL;

ALTER TABLE etudiant
    ADD CONSTRAINT uq_email UNIQUE (email);

ALTER TABLE etudiant
    ADD CONSTRAINT chk_age CHECK (age BETWEEN 15 AND 60);

ALTER TABLE etudiant
    ADD CONSTRAINT fk_etudiant_classe
        FOREIGN KEY (id_classe)
            REFERENCES classe (id_classe)
            ON DELETE RESTRICT
            ON UPDATE CASCADE;

