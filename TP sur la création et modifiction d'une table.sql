CREATE DATABASE ecole_bts;
USE ecole_bts;
CREATE TABLE etudiant
(
    id_etudiant    INT AUTO_INCREMENT PRIMARY KEY,
    nom            VARCHAR(50),
    prenom         VARCHAR(50),
    date_naissance DATE
);

ALTER TABLE etudiant
    ADD sexe VARCHAR(10);
ALTER TABLE etudiant
    ADD email VARCHAR(100);

ALTER TABLE etudiant
    MODIFY nom VARCHAR(100);

ALTER TABLE etudiant
    MODIFY email VARCHAR(100) NOT NULL;

ALTER TABLE etudiant
    Page 3 sur 3
DROP
sexe;

DROP TABLE etudiant;

