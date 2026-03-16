CREATE DATABASE microfinance;

USE microfinance;

CREATE TABLE clients
(
    id_client INT PRIMARY KEY AUTO_INCREMENT,
    nom       VARCHAR(50),
    prenom    VARCHAR(50),
    sexe      CHAR(1),
    ville     VARCHAR(50)
);

CREATE TABLE types_credit
(
    id_type    INT PRIMARY KEY AUTO_INCREMENT,
    libelle    VARCHAR(100),
    duree_mois INT
);

CREATE TABLE credits
(
    id_credit   INT PRIMARY KEY AUTO_INCREMENT,
    id_client   INT,
    id_type     INT,
    date_credit DATE,
    montant     DECIMAL(12, 2),
    statut      VARCHAR(50),
    FOREIGN KEY (id_client) REFERENCES clients (id_client),
    FOREIGN KEY (id_type) REFERENCES types_credit (id_type)
);

INSERT INTO clients (nom, prenom, sexe, ville)
VALUES ('Adjovi', 'Clarisse', 'F', 'Lome'),
       ('Kossi', 'Daniel', 'M', 'Kara'),
       ('Mensah', 'Paul', 'M', 'Sokode'),
       ('Tossou', 'Afi', 'F', 'Lome'),
       ('Ouro', 'Issa', 'M', 'Dapaong'),
       ('Amouzou', 'Kevin', 'M', 'Lome'),
       ('Boko', 'Linda', 'F', 'Kara'),
       ('Sodji', 'Emmanuel', 'M', 'Sokode'),
       ('Kouassi', 'Rita', 'F', 'Lome'),
       ('Akakpo', 'Yao', 'M', 'Kara');

INSERT INTO types_credit(libelle, duree_mois)
VALUES ('Credit Agricole', 12),
       ('Credit Commercial', 24),
       ('Credit Immobilier', 36),
       ('Credit Scolaire', 10),
       ('Credit Equipement', 18);

INSERT INTO credits(id_client, id_type, date_credit, montant, statut)
VALUES (1, 1, '2025-01-15', 500000, 'En cours'),
       (2, 2, '2025-02-10', 1200000, 'Accorde'),
       (3, 3, '2024-11-05', 3500000, 'En cours'),
       (4, 4, '2025-03-20', 400000, 'Rembourse'),
       (5, 5, '2023-12-12', 800000, 'Accorde'),
       (6, 1, '2025-01-25', 600000, 'En cours'),
       (7, 2, '2024-09-14', 1500000, 'Rembourse'),
       (8, 3, '2023-06-18', 5000000, 'Accorde'),
       (9, 4, '2025-04-01', 450000, 'En cours'),
       (10, 5, '2024-08-30', 900000, 'Accorde');


