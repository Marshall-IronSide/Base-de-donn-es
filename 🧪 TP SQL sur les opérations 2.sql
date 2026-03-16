CREATE DATABASE banque;

CREATE TABLE clients
(
    id_client INT AUTO_INCREMENT PRIMARY KEY,
    nom       VARCHAR(50),
    prenom    VARCHAR(50),
    ville     VARCHAR(50)
);

CREATE TABLE comptes
(
    id_compte   INT AUTO_INCREMENT PRIMARY KEY,
    id_client   INT,
    type_compte VARCHAR(50),
    solde       DECIMAL(10, 2),
    FOREIGN KEY (id_client) REFERENCES clients (id_client)
);

CREATE TABLE operations
(
    id_operation   INT AUTO_INCREMENT PRIMARY KEY,
    id_compte      INT,
    type_operation VARCHAR(50),
    montant        DECIMAL(10, 2),
    date_operation DATE,
    FOREIGN KEY (id_compte) REFERENCES comptes (id_compte)
);

INSERT INTO clients (nom, prenom, ville)
VALUES ('Mensah', 'Koffi', 'Lomé'),
       ('Adjovi', 'Afi', 'Cotonou'),
       ('Tchala', 'Yaw', 'Kara'),
       ('Amadou', 'Fatou', 'Lomé');

INSERT INTO comptes (id_client, type_compte, solde)
VALUES (1, 'Epargne', 150000),
       (2, 'Courant', 80000),
       (3, 'Epargne', 200000),
       (4, 'Courant', 50000);

INSERT INTO operations (id_compte, type_operation, montant, date_operation)
VALUES (1, 'Depot', 50000, '2025-02-01'),
       (1, 'Retrait', 20000, '2025-02-03'),
       (2, 'Depot', 30000, '2025-02-02'),
       (3, 'Depot', 100000, '2025-02-05'),
       (3, 'Retrait', 40000, '2025-02-06'),
       (4, 'Depot', 20000, '2025-02-07');

SELECT clients.nom, clients.prenom, comptes.type_compte, comptes.solde
FROM clients
         INNER JOIN comptes ON clients.id_client = comptes.id_client;

SELECT clients.nom, comptes.type_compte, operations.type_operation, operations.montant
FROM operations
         INNER JOIN comptes ON operations.id_compte = comptes.id_compte
         INNER JOIN clients ON comptes.id_client = clients.id_client;