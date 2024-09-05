CREATE DATABASE centre_aere;

USE centre_aere;

CREATE TABLE inscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    date_naissance DATE NOT NULL,
    email VARCHAR(100),
    telephone VARCHAR(15),
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
