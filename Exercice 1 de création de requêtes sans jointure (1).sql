CREATE TABLE etudiants
(
    id      INT AUTO_INCREMENT PRIMARY KEY,
    nom     VARCHAR(50),
    prenom  VARCHAR(50),
    filiere VARCHAR(30),
    age     INT,
    moyenne DECIMAL(4, 2),
    ville   VARCHAR(30)
);

SELECT *
FROM etudiants;

SELECT *
FROM etudiants
WHERE filiere = 'Informatique'
  AND moyenne >= 12;

SELECT *
FROM etudiants
WHERE ville = 'Lomé'
   OR filiere = 'Gestion';

SELECT *
FROM etudiants
WHERE age BETWEEN 20 AND 23;

SELECT *
FROM etudiants
WHERE moyenne NOT BETWEEN 10 AND 14;

SELECT *
FROM etudiants
WHERE filiere IN ('Informatique', 'Réseaux');

SELECT *
FROM etudiants
WHERE ville NOT IN ('Lomé', 'Kara');

SELECT *
FROM etudiants
WHERE nom LIKE 'G%';

SELECT *
FROM etudiants
WHERE prenom LIKE '%a%';

SELECT *
FROM etudiants
WHERE ville = 'Lomé'
  AND filiere = 'Informatique'
  AND moyenne BETWEEN 12 AND 17
  AND nom LIKE '%O%';