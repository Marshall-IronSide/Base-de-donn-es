CREATE TABLE clients
(
    id_client  INT AUTO_INCREMENT PRIMARY KEY,
    nom        VARCHAR(50),
    prenom     VARCHAR(50),
    sexe       CHAR(1),
    age        INT,
    profession VARCHAR(40),
    ville      VARCHAR(30),
    solde      DECIMAL(10, 2)
);

INSERT INTO clients (nom, prenom, sexe, age, profession, ville, solde)
VALUES ('ADJE', 'Kossi', 'M', 35, 'Commerçant', 'Lomé', 350000),
       ('DOSSOU', 'Afi', 'F', 28, 'Couturière', 'Aného', 120000),
       ('KPADONOU', 'Yao', 'M', 42, 'Agriculteur', 'Kara', 80000),
       ('MENSAH', 'Akou', 'F', 31, 'Enseignante', 'Lomé', 250000),
       ('TCHALLA', 'Sami', 'M', 26, 'Étudiant', 'Sokodé', 45000),
       ('HOUNGBEDJI', 'Mariam', 'F', 38, 'Comptable', 'Atakpamé', 410000),
       ('ASSOGBA', 'Koffi', 'M', 47, 'Transporteur', 'Lomé', 600000),
       ('AGOSSOU', 'Linda', 'F', 22, 'Étudiante', 'Tsévié', 30000),
       ('KOUASSI', 'Jean', 'M', 34, 'Informaticien', 'Kara', 520000),
       ('ADANDE', 'Nadia', 'F', 29, 'Commerçante', 'Lomé', 150000);

