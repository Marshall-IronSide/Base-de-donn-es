CREATE TABLE patients
(
    id_patient         INT AUTO_INCREMENT PRIMARY KEY,
    nom                VARCHAR(50),
    prenom             VARCHAR(50),
    sexe               CHAR(1),
    age                INT,
    maladie            VARCHAR(50),
    ville              VARCHAR(30),
    frais_consultation DECIMAL(10, 2)
);

INSERT INTO patients (nom, prenom, sexe, age, maladie, ville, frais_consultation)
VALUES ('AMOU', 'Kevin', 'M', 33, 'Paludisme', 'Lomé', 15000),
       ('BANSAH', 'Elodie', 'F', 25, 'Typhoïde', 'Kara', 22000),
       ('DOVI', 'Ruth', 'F', 40, 'Diabète', 'Aného', 50000),
       ('KOFFI', 'Marc', 'M', 29, 'Grippe', 'Lomé', 10000),
       ('SALIFOU', 'Aicha', 'F', 36, 'Hypertension', 'Sokodé', 45000),
       ('TCHAGNAO', 'Paul', 'M', 50, 'Asthme', 'Atakpamé', 38000),
       ('ADJOVI', 'Mireille', 'F', 19, 'Paludisme', 'Tsévié', 12000),
       ('YAO', 'Serge', 'M', 44, 'Diabète', 'Lomé', 55000),
       ('AGBODJAN', 'Clarisse', 'F', 31, 'Typhoïde', 'Kpalimé', 27000),
       ('OSSENI', 'Karim', 'M', 27, 'Grippe', 'Kara', 9000);

