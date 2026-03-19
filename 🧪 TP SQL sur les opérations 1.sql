CREATE DATABASE supermarche;
CREATE TABLE ventes
(
    id_vente      INT AUTO_INCREMENT PRIMARY KEY,
    produit       VARCHAR(50),
    categorie     VARCHAR(50),
    vendeur       VARCHAR(50),
    quantite      INT,
    prix_unitaire DECIMAL(10, 2),
    date_vente    DATE
);

INSERT INTO ventes (produit, categorie, vendeur, quantite, prix_unitaire, date_vente)
VALUES ('Riz', 'Alimentation', 'Paul', 10, 500, '2025-01-10'),
       ('Huile', 'Alimentation', 'Marie', 5, 1200, '2025-01-11'),
       ('Savon', 'Hygiène', 'Paul', 20, 300, '2025-01-12'),
       ('Dentifrice', 'Hygiène', 'Jean', 8, 700, '2025-01-13'),
       ('Sucre', 'Alimentation', 'Marie', 12, 600, '2025-01-14'),
       ('Lait', 'Alimentation', 'Jean', 6, 800, '2025-01-15'),
       ('Shampoing', 'Hygiène', 'Paul', 7, 1500, '2025-01-16');

SELECT COUNT(*) AS nombre_ventes
FROM ventes;

SELECT SUM(quantite) AS total_quantite
FROM ventes;

SELECT AVG(prix_unitaire) AS prix_moyen
FROM ventes;

SELECT MIN(prix_unitaire) AS prix_minimum
FROM ventes;

SELECT MAX(prix_unitaire) AS prix_maximum
FROM ventes;

SELECT produit, prix_unitaire
FROM ventes
ORDER BY prix_unitaire DESC;

SELECT vendeur, SUM(quantite) AS total_vendu
FROM ventes
GROUP BY vendeur;

SELECT categorie, COUNT(*) AS nombre_ventes
FROM ventes
GROUP BY categorie;

SELECT categorie, AVG(prix_unitaire) AS prix_moyen
FROM ventes
GROUP BY categorie;

SELECT vendeur, SUM(quantite) AS total_vendu
FROM ventes
GROUP BY vendeur
ORDER BY total_vendu DESC;