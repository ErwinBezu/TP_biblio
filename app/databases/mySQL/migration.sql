-- Création de la base de données
CREATE DATABASE IF NOT EXISTS library;
USE library;

-- Table des utilisateurs
CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       name VARCHAR(100),
                       email VARCHAR(100),
                       password VARCHAR(100),
                       role VARCHAR(100),
                       createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des livres
CREATE TABLE books (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       title VARCHAR(255),
                       author VARCHAR(100),
                       isbn VARCHAR(20),
                       createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des catégories
CREATE TABLE categories (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(100),
                            createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table de relation livres ↔ catégories (many-to-many)
CREATE TABLE book_category (
                               bookId INT,
                               categoryId INT,
                               PRIMARY KEY (bookId, categoryId),
                               FOREIGN KEY (bookId) REFERENCES books(id),
                               FOREIGN KEY (categoryId) REFERENCES categories(id),
                               createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                               updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table de relation users ↔ books (many-to-many)
CREATE TABLE users_books (
                             bookId INT,
                             userId INT,
                             PRIMARY KEY (bookId, userId),
                             FOREIGN KEY (bookId) REFERENCES books(id),
                             FOREIGN KEY (userId) REFERENCES users(id),
                             createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                             updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
