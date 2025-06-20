<?php

namespace App\Controllers;
use App\Repositories\BookRepository;
use App\Configs\MySqlConnection;
use App\Models\Book;
use App\Services\BookService;
use PDO;

class BookController extends CoreController
{
    private BookService $bookService;

    public function __construct()
    {
        $db = MySqlConnection::getConnection();
        $bookRepository = new BookRepository($db);
        $this->bookService = new BookService($bookRepository);
    }

    public function index()
    {
        $books = $this->bookService->getBooks();
        $this->show('book/index', ['books' => $books]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $book = new Book([
                'title' => $_POST['title'] ?? null,
                'author' => $_POST['author'] ?? null,
                'isbn' => $_POST['isbn'] ?? null
            ]);

            if ($this->bookService->createBook($book)) {
                header('Location: /books');
                exit;
            } else {
                $error = "Erreur lors de la création du livre";
            }
        }

        $this->show('book/create', ['error' => $error ?? null]);
    }

    public function detail(int $id)
    {
        $book = $this->bookService->getBookById($id);
        $this->show('book/show', ['book' => $book]);
    }

    public function edit(int $id)
    {
        $book = $this->bookService->getBookById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $book->setTitle($_POST['title'] ?? null);
            $book->setAuthor($_POST['author'] ?? null);
            $book->setIsbn($_POST['isbn'] ?? null);

            if ($this->bookService->updateBook($book)) {
                $success = "Livre modifié avec succès";
            } else {
                $error = "Erreur lors de la modification";
            }
        }

        $this->show('book/edit', [
            'book' => $book,
            'success' => $success ?? null,
            'error' => $error ?? null
        ]);
    }

    public function delete(int $id)
    {
        $book = $this->bookService->getBookById($id);

        if (!$book) {
            header('Location: /books');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->bookService->deleteBook($book)) {
                header('Location: /books?deleted=1');
                exit;
            } else {
                $error = "Erreur lors de la suppression";
            }
        }

        $this->show('book/delete', ['book' => $book, 'error' => $error ?? null]);
    }
}