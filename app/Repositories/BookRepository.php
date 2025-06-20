<?php

namespace App\Repositories;

use PDO;
use App\Configs\MySqlConnection;
use App\Mappers\BookMapper;
use App\Models\Book;

class BookRepository
{
    public function __construct(private PDO $db) {

    }

    public function findById(int $id): Book|false {
        $sql = 'SELECT * FROM books WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute(["id"=> $id]);

        $book = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$book) {
            return false;
        }

        return BookMapper::fromDatabase($book);
    }

    public function findAll() {
        $sql = 'SELECT * FROM books';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return BookMapper::fromDatabaseMultiple($books);
    }

    public function create(Book $book): Book {
        $sql= ' INSERT INTO books ( title, author, isbn )
            VALUES (:title, :author, :isbn)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':title', $book->getTitle(), PDO::PARAM_STR);
        $stmt->bindValue(':author', $book->getAuthor(), PDO::PARAM_STR);
        $stmt->bindValue(':isbn', $book->getIsbn(), PDO::PARAM_STR);
        $stmt->execute();

        $book->setId($this->db->lastInsertId());

        return $book;
    }

    public function update(Book $book): Book {
        $sql='UPDATE books
            SET title = :title, author = :author, isbn = :isbn
            WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':title', $book->getTitle(), PDO::PARAM_STR);
        $stmt->bindValue(':author', $book->getAuthor(), PDO::PARAM_STR);
        $stmt->bindValue(':isbn', $book->getIsbn(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $book->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $book;
    }

}