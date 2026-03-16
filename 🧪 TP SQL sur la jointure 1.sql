CREATE DATABASE gestion_formation;

CREATE TABLE etudiants
(
    id_etudiant    INT PRIMARY KEY AUTO_INCREMENT,
    nom            VARCHAR(50),
    prenom         VARCHAR(50),
    sexe           CHAR(1),
    date_naissance DATE,
    ville          VARCHAR(50)
);

CREATE TABLE filieres
(
    id_filiere  INT PRIMARY KEY AUTO_INCREMENT,
    nom_filiere VARCHAR(100),
    niveau      VARCHAR(50)
);

CREATE TABLE inscriptions
(
    id_inscription   INT PRIMARY KEY AUTO_INCREMENT,
    id_etudiant      INT,
    id_filiere       INT,
    annee_academique VARCHAR(9),
    montant_paye     DECIMAL(10, 2),
    FOREIGN KEY (id_etudiant) REFERENCES etudiants (id_etudiant),
    FOREIGN KEY (id_filiere) REFERENCES filieres (id_filiere)
);

INSERT INTO etudiants(nom, prenom, sexe, date_naissance, ville)
VALUES ('Amouzou', 'Kevin', 'M', '2003-05-12', 'Lome'),
       ('Kossi', 'Afi', 'F', '2002-09-21', 'Kara'),
       ('Mensah', 'Joelle', 'F', '2001-11-03', 'Sokode'),
       ('Akakpo', 'Yao', 'M', '2004-02-18', 'Lome'),
       ('Tossou', 'Mariam', 'F', '2003-07-30', 'Kara'),
       ('Ouro', 'Ismael', 'M', '2002-03-15', 'Dapaong'),
       ('Adjovi', 'Linda', 'F', '2001-12-25', 'Lome'),
       ('Boko', 'Ali', 'M', '2000-06-10', 'Sokode'),
       ('Kouassi', 'Rita', 'F', '2003-08-08', 'Kara'),
       ('Sodji', 'Emmanuel', 'M', '2002-01-17', 'Lome');

INSERT INTO filieres(nom_filiere, niveau)
VALUES ('Informatique de Gestion', 'Licence 1'),
       ('Informatique de Gestion', 'Licence 2'),
       ('Informatique de Gestion', 'Licence 3'),
       ('Gestion Commerciale', 'Licence 1'),
       ('Gestion Commerciale', 'Licence 2'),
       ('Finance Comptabilite', 'Master 1'),
       ('Finance Comptabilite', 'Master 2');

INSERT INTO inscriptions (id_etudiant, id_filiere, annee_academique, montant_paye)
VALUES (1, 1, '2025-2026', 450000),
       (2, 2, '2025-2026', 500000),
       (3, 3, '2024-2025', 650000),
       (4, 4, '2025-2026', 300000),
       (5, 5, '2024-2025', 550000),
       (6, 6, '2023-2024', 900000),
       (7, 1, '2025-2026', 400000),
       (8, 2, '2024-2025', 480000),
       (9, 7, '2025-2026', 950000),
       (10, 3, '2023-2024', 700000);

/*Jointure simple: Afficher la liste des étudiants avec la filière choisie*/

SELECT e.nom, e.prenom, f.nom_filiere
FROM etudiants e
         INNER JOIN inscriptions i ON e.id_etudiant = i.id_etudiant
         INNER JOIN filieres f ON i.id_filiere = f.id_filiere;

/*Utilisation de WHERE + AND: Afficher les étudiants inscrits en "Licence 1" pour l’année académique 2025-2026*/
SELECT e.nom, e.prenom, f.nom_filiere, i.annee_academique
FROM etudiants e
         INNER JOIN inscriptions i ON e.id_etudiant = i.id_etudiant
         INNER JOIN filieres f ON i.id_filiere = f.id_filiere
WHERE f.niveau = 'Licence 1'
  AND i.annee_academique = '2025-2026';

/*Utilisation de BETWEEN:Afficher les étudiants ayant payé entre 300000 et 600000 FCFA*/

SELECT e.nom, e.prenom, i.montant_paye
FROM etudiants e
         INNER JOIN inscriptions i on e.id_etudiant = i.id_etudiant
WHERE i.montant_paye BETWEEN 300000 AND 600000;

/*Utilisation de IN*/
SELECT e.nom, e.prenom, f.niveau
FROM etudiants e
         INNER JOIN inscriptions i ON e.id_etudiant = i.id_etudiant
         INNER JOIN filieres f ON i.id_filiere = f.id_filiere
WHERE f.niveau IN ('Licence 1', 'Licence 2');

/*Utilisation de NOT:Afficher les étudiants qui ne sont PAS en Licence 3*/
SELECT e.nom, e.prenom, f.niveau
FROM etudiants e
         INNER JOIN inscriptions i ON e.id_etudiant = i.id_etudiant
         INNER JOIN filieres f ON i.id_filiere = f.id_filiere
WHERE f.niveau NOT IN ('Licence 3');

/*Utilisation de LIKE:Afficher les étudiants dont le nom commence par "A"*/
SELECT e.nom, e.prenom
FROM etudiants e
         INNER JOIN inscriptions i ON e.id_etudiant = i.id_etudiant
WHERE e.nom LIKE 'A%';

/*Afficher les filières contenant le mot "Informatique"*/
SELECT f.nom_filiere
FROM filieres f
         INNER JOIN inscriptions i ON f.id_filiere = i.id_filiere
WHERE f.nom_filiere LIKE '%Informatique%';

/*Utilisation de OR*/

SELECT e.nom, e.prenom, e.ville
FROM etudiants e
         INNER JOIN inscriptions i ON e.id_etudiant = i.id_etudiant
WHERE e.ville = 'Lome'
   OR e.ville = 'Kara';

/*Requête complète combinée*/
SELECT e.nom, e.prenom, f.niveau, i.montant_paye
FROM etudiants e
         INNER JOIN inscriptions i
                    ON e.id_etudiant = i.id_etudiant
         INNER JOIN filieres f ON i.id_filiere = f.id_filiere
WHERE f.niveau IN ('Licence 1', 'Licence 2')
  AND i.montant_paye BETWEEN 300000 AND 700000
  AND e.nom LIKE '%o%';
