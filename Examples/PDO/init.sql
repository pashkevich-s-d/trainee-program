CREATE DATABASE IF NOT EXISTS users_database;
GRANT ALL PRIVILEGES ON users_database.* TO 'app'@'%' IDENTIFIED BY 'pass';

USE users_database;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    surname VARCHAR(30) NOT NULL
);

INSERT INTO users (name, surname) VALUES ('John', 'Jonhson'), ('Jules', 'Jourdan') , ('Katelyn', 'Gold');
