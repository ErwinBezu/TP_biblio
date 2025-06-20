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
        $book = BookMapper::entityToBook($stmt->fetch(PDO::FETCH_ASSOC));
        return $book;
    }

    public function findAll() {
        $sql = 'SELECT * FROM books';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return BookMapper::entitiesToBooks($books);
    }

    public function create(Book $book): Book {
        $sql=  
    }

}