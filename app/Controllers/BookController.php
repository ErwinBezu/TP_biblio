<?php

namespace App\Controllers;

use App\Services\BookService;
use App\Repositories\BookRepository;
use App\Repositories\CategoryRepository;
use App\Configs\MySqlConnection;
use App\Exceptions\BookNotFoundException;
use App\Exceptions\BookCreationException;
use App\Exceptions\BookUpdateException;
use App\Exceptions\BookDeletionException;
use App\Exceptions\InvalidBookDataException;
use App\Exceptions\CategoryNotFoundException;
use Exception;

class BookController extends CoreController
{
    private BookService $bookService;

    public function __construct()
    {
        $db = MySqlConnection::getConnection();
        $bookRepository = new BookRepository($db);
        $categoryRepository = new CategoryRepository($db);
        $this->bookService = new BookService($bookRepository, $categoryRepository);
    }

    public function test(): void
    {
        $books = $this->bookService->getBooksWithCategories();
        $this->show('book/index', ['books' => $books]);

    }

    public function index():void
    {

        echo "Méthode index appelée<br>";
        $booksWithCategories = $this->bookService->getBooksWithCategories();
        echo "Nombre de livres récupérés: " . count($booksWithCategories) . "<br>";
        var_dump($booksWithCategories); // Pour voir le contenu

        $this->show('book/index', ['booksWithCategories' => $booksWithCategories]);
//        $booksWithCategories = $this->bookService->getBooksWithCategories();
//        $this->show('book/index', ['booksWithCategories' => $booksWithCategories]);
    }

    public function create()
    {
        $categories = $this->bookService->getAllCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $categoryIds = $this->extractCategoryIds($_POST);

                $this->bookService->createBook([
                    'title' => $_POST['title'] ?? '',
                    'author' => $_POST['author'] ?? '',
                    'isbn' => $_POST['isbn'] ?? ''
                ], $categoryIds);

                header('Location: /books');
                exit;
            } catch (InvalidBookDataException | CategoryNotFoundException $e) {
                $error = $e->getMessage();
            } catch (BookCreationException $e) {
                $error = $e->getMessage();
            }
        }

        $this->show('book/create', [
            'categories' => $categories,
            'selectedCategories' => $_POST['categories'] ?? [],
            'error' => $error ?? null
        ]);
    }

    public function detail(int $id): void
    {
        try {
            $bookWithCategories = $this->bookService->getBookWithCategories($id);
            $this->show('book/show', $bookWithCategories);
        } catch (BookNotFoundException $e) {
            header('HTTP/1.0 404 Not Found');
            $this->show('errors/404');
        }
    }

    public function edit(int $id)
    {
        try {
            $bookWithCategories = $this->bookService->getBookWithCategories($id);
            $allCategories = $this->bookService->getAllCategories();

            $selectedCategoryIds = array_map(
                fn($cat) => $cat->getId(),
                $bookWithCategories['categories']
            );
        } catch (BookNotFoundException $e) {
            header('Location: /books');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $categoryIds = $this->extractCategoryIds($_POST);

                $this->bookService->updateBook($id, [
                    'title' => $_POST['title'] ?? '',
                    'author' => $_POST['author'] ?? '',
                    'isbn' => $_POST['isbn'] ?? ''
                ], $categoryIds);

                $success = "Livre modifié avec succès";

                // Recharger les données après modification
                $bookWithCategories = $this->bookService->getBookWithCategories($id);
                $selectedCategoryIds = array_map(
                    fn($cat) => $cat->getId(),
                    $bookWithCategories['categories']
                );

            } catch (InvalidBookDataException | CategoryNotFoundException $e) {
                $error = $e->getMessage();
                $selectedCategoryIds = $this->extractCategoryIds($_POST);
            } catch (BookUpdateException $e) {
                $error = $e->getMessage();
                $selectedCategoryIds = $this->extractCategoryIds($_POST);
            }
        }

        $this->show('book/edit', [
            'book' => $bookWithCategories['book'],
            'categories' => $allCategories,
            'selectedCategories' => $selectedCategoryIds,
            'success' => $success ?? null,
            'error' => $error ?? null
        ]);
    }

    public function delete(int $id)
    {
        try {
            $bookWithCategories = $this->bookService->getBookWithCategories($id);
        } catch (BookNotFoundException $e) {
            header('Location: /books');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->bookService->deleteBook($id);
                header('Location: /books?deleted=1');
                exit;
            } catch (BookDeletionException $e) {
                $error = $e->getMessage();
            }
        }

        $this->show('book/delete', [
            'book' => $bookWithCategories['book'],
            'categories' => $bookWithCategories['categories'],
            'error' => $error ?? null
        ]);
    }
    public function addCategory(int $bookId, int $categoryId)
    {
        try {
            $this->bookService->addCategoryToBook($bookId, $categoryId);
            header("Location: /books/{$bookId}");
            exit;
        } catch (BookNotFoundException | CategoryNotFoundException | BookUpdateException $e) {
            // Rediriger avec message d'erreur
            header("Location: /books/{$bookId}?error=" . urlencode($e->getMessage()));
            exit;
        }
    }

    public function removeCategory(int $bookId, int $categoryId)
    {
        try {
            $this->bookService->removeCategoryFromBook($bookId, $categoryId);
            header("Location: /books/{$bookId}");
            exit;
        } catch (BookUpdateException $e) {
            header("Location: /books/{$bookId}?error=" . urlencode($e->getMessage()));
            exit;
        }
    }

    public function byCategory(int $categoryId)
    {
        try {
            $books = $this->bookService->getBooksByCategory($categoryId);
            $categories = $this->bookService->getAllCategories();

            // Trouver la catégorie actuelle
            $currentCategory = null;
            foreach ($categories as $category) {
                if ($category->getId() === $categoryId) {
                    $currentCategory = $category;
                    break;
                }
            }

            if (!$currentCategory) {
                header('Location: /books');
                exit;
            }

            $this->show('book/by-category', [
                'books' => $books,
                'currentCategory' => $currentCategory,
                'allCategories' => $categories
            ]);

        } catch (Exception $e) {
            header('Location: /books');
            exit;
        }
    }

    // === MÉTHODES UTILITAIRES ===

    private function extractCategoryIds(array $postData): array
    {
        $categoryIds = $postData['categories'] ?? [];
        return array_filter(
            array_map('intval', (array)$categoryIds),
            fn($id) => $id > 0
        );
    }
}