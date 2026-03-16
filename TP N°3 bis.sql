USE gestion_universite;

SHOW TABLES;

INSERT INTO etudiants (nom, prenom, email, age, sexe, nationalite)
VALUES ('Doe', 'Junior', 'junior.doe@mail.com', 21, 'Masculin', 'Togolaise');

INSERT INTO etudiants (nom, prenom, email, age, sexe, nationalite)
VALUES ('Kossi', 'Marc', 'marc.kossi@mail.com', 22, 'Masculin', 'Togolaise'),
       ('Afi', 'Claire', 'claire.afi@mail.com', 20, 'Féminin', 'Togolaise');

CREATE TABLE etudiants_archive AS
SELECT *
FROM etudiants
WHERE 1 = 0;

INSERT INTO etudiants_archive
SELECT *
FROM etudiants Page 3 sur 9
WHERE age > 25;

UPDATE etudiants
SET nationalite = 'TOGO'
WHERE nationalite = 'Togolaise';

UPDATE etudiants
SET age = age + 1;

UPDATE inscriptions
SET id_formation = (SELECT id_formation
                    FROM formations
                    WHERE libelle = 'Informatique' Page 4 sur 9)
WHERE id_etudiant IN (SELECT id_etudiant
                      FROM etudiants);

DELETE
FROM etudiants
WHERE age > 30;

DELETE
FROM inscriptions
WHERE id_formation NOT IN (SELECT id_formation
                           FROM formations);

SELECT *
FROM etudiants
WHERE age < 18;


DELETE
FROM etudiants Page 5 sur 9
WHERE age < 18;

START TRANSACTION;
DELETE
FROM etudiants
WHERE age > 40;

INSERT INTO formations (libelle, duree, frais)
VALUES ('Informatique', 24, 150000),
       ('Gestion', 18, 120000),
       ('Comptabilité', 12, 100000);

INSERT INTO inscriptions (id_etudiant, id_formation, date_inscription)
VALUES (2, 1, CURRENT_DATE),
       (3, 1, CURRENT_DATE);

INSERT INTO inscriptions (id_etudiant, id_formation)
VALUES ((SELECT id_etudiant FROM etudiants WHERE email = 'marc.kossi@mail.com'),
        (SELECT id_formation FROM formations WHERE libelle = 'Informatique')),
       ((SELECT id_etudiant FROM etudiants WHERE email = 'claire.afi@mail.com'),
        (SELECT id_formation FROM formations WHERE libelle = 'Informatique'));

UPDATE formations
SET frais = frais * 1.10
WHERE libelle = 'Informatique';
Vérification
SELECT libelle, frais
FROM formations
WHERE libelle = 'Informatique';

SELECT *
FROM inscriptions
WHERE YEAR(date_inscription) = YEAR(CURRENT_DATE) - 1;

DELETE
FROM inscriptions
WHERE YEAR(date_inscription) = YEAR(CURRENT_DATE) - 1;

SELECT *
FROM etudiants
WHERE id_etudiant IN (SELECT id_etudiant
                      FROM inscriptions);

UPDATE inscriptions
SET id_formation = (SELECT id_formation
                    FROM formations
                    WHERE libelle = 'Informatique');

UPDATE inscriptions
SET id_formation = 5;

UPDATE inscriptions
SET id_formation = (SELECT id_formation
                    FROM formations
                    WHERE libelle = 'Informatique');

DELETE
FROM etudiants
WHERE id_etudiant NOT IN (SELECT id_etudiant
                          FROM inscriptions);

