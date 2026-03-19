CREATE
    DATABASE bibliotheque;
USE
    bibliotheque;

CREATE TABLE etudiants
(
    id_etudiant INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(50),
    prenom      VARCHAR(50),
    filiere     VARCHAR(50)
);

CREATE TABLE livres
(
    id_livre  INT AUTO_INCREMENT PRIMARY KEY,
    titre     VARCHAR(100),
    auteur    VARCHAR(100),
    categorie VARCHAR(50),
    prix      DECIMAL(10, 2)
);

CREATE TABLE emprunts
(
    id_emprunt   INT AUTO_INCREMENT PRIMARY KEY,
    id_etudiant  INT,
    id_livre     INT,
    date_emprunt DATE,
    date_retour  DATE,
    FOREIGN KEY (id_etudiant) REFERENCES etudiants (id_etudiant),
    FOREIGN KEY (id_livre) REFERENCES livres (id_livre)
);

INSERT INTO etudiants (nom, prenom, filiere)
VALUES ('Mensah', 'Kossi', 'Informatique'),
       ('Adjovi', 'Afi', 'Gestion'),
       ('Tchala', 'Yaw', 'Informatique'),
       ('Amadou', 'Fatou', 'Comptabilité'),
       ('Komi', 'Eli', 'Gestion');

INSERT INTO livres (titre, auteur, categorie, prix)
VALUES ('Base de données', 'Elmasri', 'Informatique', 15000),
       ('SQL pratique', 'Dupont', 'Informatique', 12000),
       ('Comptabilité générale', 'Martin', 'Gestion', 18000),
       ('Marketing moderne', 'Durand', 'Gestion', 14000),
       ('Programmation PHP', 'Smith', 'Informatique', 16000);

INSERT INTO emprunts (id_etudiant, id_livre, date_emprunt, date_retour)
VALUES (1, 1, '2025-02-01', '2025-02-10'),
       (2, 3, '2025-02-02', '2025-02-11'),
       (3, 2, '2025-02-03', '2025-02-12'),
       (1, 5, '2025-02-05', '2025-02-14'),
       (4, 3, '2025-02-06', '2025-02-15'),
       (5, 4, '2025-02-07', '2025-02-16'),
       (2, 2, '2025-02-08', '2025-02-17');

/*Exo1*/
SELECT nom, prenom, filiere
FROM etudiants;

/*Exo2*/
SELECT titre, auteur, prix
FROM livres
ORDER BY prix DESC;

/*Exo3*/
SELECT COUNT(*) AS nombre_total_livres
FROM livres;

/*Exo4*/
SELECT AVG(prix) AS prix_moyen
FROM livres;

/*Exo5*/
SELECT MIN(prix) AS prix_minimum,
       MAX(prix) AS prix_maximum
FROM livres;

/*afficher les titres correspondants*/
SELECT titre, prix
FROM livres
WHERE prix = (SELECT MIN(prix) FROM livres)
UNION
SELECT titre, prix
FROM livres
WHERE prix = (SELECT MAX(prix) FROM livres);

/*Exo6*/
SELECT e.nom, e.prenom, l.titre, em.date_emprunt, em.date_retour
FROM emprunts em
         JOIN etudiants e ON em.id_etudiant = e.id_etudiant
         JOIN livres l ON em.id_livre = l.id_livre;

/*Exo7*/
SELECT e.nom, e.prenom, COUNT(em.id_emprunt) AS nombre_emprunts
FROM etudiants e
         JOIN emprunts em ON e.id_etudiant = em.id_etudiant
GROUP BY e.id_etudiant, e.nom, e.prenom;

/*Exo8*/
SELECT l.categorie, COUNT(em.id_emprunt) AS nombre_emprunts
FROM livres l
         JOIN emprunts em ON l.id_livre = em.id_livre
GROUP BY l.categorie;

/*Exo9*/
SELECT e.nom, e.prenom, COUNT(em.id_emprunt) AS nombre_emprunts
FROM etudiants e
         JOIN emprunts em ON e.id_etudiant = em.id_etudiant
GROUP BY e.id_etudiant, e.nom, e.prenom
HAVING COUNT(em.id_emprunt) > 1;

/*Exo10*/
SELECT e.filiere, COUNT(em.id_emprunt) AS nombre_emprunts
FROM etudiants e
         JOIN emprunts em ON e.id_etudiant = em.id_etudiant
GROUP BY e.filiere;

/*Exo11*/
SELECT categorie, AVG(prix) AS prix_moyen
FROM livres
GROUP BY categorie
HAVING AVG(prix) > 14000;

/*Exo12*/
SELECT e.nom, e.prenom, COUNT(em.id_emprunt) AS nombre_emprunts
FROM etudiants e
         JOIN emprunts em ON e.id_etudiant = em.id_etudiant
GROUP BY e.id_etudiant, e.nom, e.prenom
ORDER BY nombre_emprunts DESC;