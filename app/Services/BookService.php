<?php
namespace App\Services;

use App\Models\Book;
use App\Repositories\BookRepository;
use PDOException;

class BookService
{
    public function __construct(
        private BookRepository $bookRepository
    ){}
    public function getBooks(): array
    {
        $books =[];
        try{
            $books = $this->bookRepository->findAll();
        }catch (PDOException $e){
            error_log("Erreur lors de la recherche findAll : " .$e->getMessage());
        }
        return $books;
    }
    public function getBookById(int $id): Book|false
    {
        try {
            return $this->bookRepository->findById($id);
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche par ID : " . $e->getMessage());
            return false;
        }
    }
    public function createBook(Book $bookToCreate): bool{
        try{
            $this->bookRepository->create($bookToCreate);
            return true;
        } catch(PDOException $e){
            error_log("Erreur lors de la création : " . $e->getMessage());
            return false;
        }
    }
    public function updateBook(Book $book): bool
    {
        try {
            $this->bookRepository->update($book);
            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour : " . $e->getMessage());
            return false;
        }
    }
    public function deleteBook(Book $book): bool
    {
        try {
            $this->bookRepository->delete($book);
            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression : " . $e->getMessage());
            return false;
        }
    }

}