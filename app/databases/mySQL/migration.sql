-- Création de la base de données
CREATE DATABASE IF NOT EXISTS library;
USE library;

-- Table des utilisateurs
CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       name VARCHAR(100),
                       email VARCHAR(100)
);

-- Table des livres
CREATE TABLE books (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       title VARCHAR(255),
                       author VARCHAR(100),
                       isbn VARCHAR(20)
);

-- Table des catégories
CREATE TABLE categories (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(100)
);

-- Table de relation livres ↔ catégories (many-to-many)
CREATE TABLE book_category (
                               book_id INT,
                               category_id INT,
                               PRIMARY KEY (book_id, category_id),
                               FOREIGN KEY (book_id) REFERENCES books(id),
                               FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Table de relation users ↔ books (many-to-many)
CREATE TABLE users_books (
                             book_id INT,
                             user_id INT,
                             PRIMARY KEY (book_id, user_id),
                             FOREIGN KEY (book_id) REFERENCES books(id),
                             FOREIGN KEY (user_id) REFERENCES users(id)
);
