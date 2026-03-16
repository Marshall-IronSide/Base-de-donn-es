CREATE DATABASE gestion_universite
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;
USE gestion_universite;

CREATE TABLE etudiants
(
    id_etudiant INT AUTO_INCREMENT,
    nom         VARCHAR(50)  NOT NULL,
    prenom      VARCHAR(50)  NOT NULL,
    email       VARCHAR(100) NOT NULL UNIQUE,
    age         INT          NOT NULL,
    CONSTRAINT pk_etudiant PRIMARY KEY (id_etudiant),
    CONSTRAINT chk_age CHECK (age >= 17)
);

CREATE TABLE formations
(
    id_formation   INT AUTO_INCREMENT,
    code_formation VARCHAR(10)    NOT NULL UNIQUE,
    libelle        VARCHAR(100)   NOT NULL,
    frais          DECIMAL(10, 2) NOT NULL,
    CONSTRAINT pk_formation PRIMARY KEY (id_formation),
    CONSTRAINT chk_frais CHECK (frais > 0)
);

CREATE TABLE inscriptions
(
    id_inscription   INT AUTO_INCREMENT,
    id_etudiant      INT  NOT NULL,
    id_formation     INT  NOT NULL,
    date_inscription DATE NOT NULL,
    CONSTRAINT pk_inscription PRIMARY KEY (id_inscription),
    CONSTRAINT fk_etudiant FOREIGN KEY (id_etudiant)
        REFERENCES etudiants (id_etudiant)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_formation FOREIGN KEY (id_formation)
        REFERENCES formations (id_formation)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT uc_inscription UNIQUE (id_etudiant, id_formation)
);

INSERT INTO etudiants (nom, prenom, email, age)
VALUES ('Koffi', 'Jean', 'jean@mail.com', 20);

INSERT INTO etudiants (nom, prenom, email, age)
VALUES ('Mensah', 'Paul', 'jean@mail.com', 22);

INSERT INTO etudiants (nom, prenom, email, age)
VALUES ('Doe', 'Junior', 'junior@mail.com', 15);

INSERT INTO inscriptions (id_etudiant, id_formation, date_inscription)
VALUES (99, 1, '2025-10-01');

