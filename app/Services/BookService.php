<?php
namespace App\Services;

use App\Models\Book;
use App\Repositories\BookRepository;
use App\Repositories\CategoryRepository;
use App\Exceptions\BookNotFoundException;
use App\Exceptions\BookCreationException;
use App\Exceptions\BookUpdateException;
use App\Exceptions\BookDeletionException;
use App\Exceptions\InvalidBookDataException;
use App\Exceptions\CategoryNotFoundException;
use PDOException;

class BookService
{
    public function __construct(
        private BookRepository $bookRepository,
        private CategoryRepository $categoryRepository
    ) {}

    public function getBooks(): array
    {
        try {
            return $this->bookRepository->findAll();
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des livres : " . $e->getMessage());
            return [];
        }
    }

    public function getBooksWithCategories(): array
    {
        try {
            return $this->bookRepository->findBooksWithCategories();
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des livres avec catégories : " . $e->getMessage());
            return [];
        }
    }

    public function getBookById(int $id): Book
    {
        try {
            $book = $this->bookRepository->findById($id);
            if (!$book) {
                throw new BookNotFoundException("Livre avec l'ID {$id} introuvable");
            }
            return $book;
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche par ID : " . $e->getMessage());
            throw new BookNotFoundException("Impossible de récupérer le livre");
        }
    }

    public function getBookWithCategories(int $id): array
    {
        $book = $this->getBookById($id);
        $categories = $this->getBookCategories($id);

        return [
            'book' => $book,
            'categories' => $categories
        ];
    }

    public function createBook(array $data, array $categoryIds = []): Book
    {
        $this->validateBookData($data);
        $this->validateCategoryIds($categoryIds);


        try {
            $book = new Book($data);
            $createdBook = $this->bookRepository->create($book);

            // Associer les catégories si présentes
            if (!empty($categoryIds)) {
                $this->syncBookCategories($createdBook->getId(), $categoryIds);
            }

            return $createdBook;
        } catch (PDOException $e) {
            error_log("Erreur lors de la création : " . $e->getMessage());
            throw new BookCreationException("Impossible de créer le livre");
        }
    }

    public function updateBook(int $id, array $data, array $categoryIds = []): Book
    {
        $book = $this->getBookById($id);
        $this->validateBookData($data);
        $this->validateCategoryIds($categoryIds);

        try {
            $book->setTitle($data['title']);
            $book->setAuthor($data['author']);
            $book->setIsbn($data['isbn']);

            $updatedBook = $this->bookRepository->update($book);

            // Synchroniser les catégories
            $this->syncBookCategories($id, $categoryIds);

            return $updatedBook;
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour : " . $e->getMessage());
            throw new BookUpdateException("Impossible de modifier le livre");
        }
    }

    public function deleteBook(int $id): void
    {
        $book = $this->getBookById($id);

        try {
            // Les catégories seront supprimées automatiquement grâce au CASCADE
            $this->bookRepository->delete($book);
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression : " . $e->getMessage());
            throw new BookDeletionException("Impossible de supprimer le livre");
        }
    }
    public function getBookCategories(int $bookId): array
    {
        try {
            return $this->bookRepository->findCategoriesByBookId($bookId);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des catégories : " . $e->getMessage());
            return [];
        }
    }

    public function getBooksByCategory(int $categoryId): array
    {
        try {
            return $this->bookRepository->findBooksByCategoryId($categoryId);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des livres par catégorie : " . $e->getMessage());
            return [];
        }
    }

    public function addCategoryToBook(int $bookId, int $categoryId): void
    {
        $this->getBookById($bookId); // Vérifier que le livre existe
        $this->validateCategoryExists($categoryId);

        try {
            $this->bookRepository->addCategoryToBook($bookId, $categoryId);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de catégorie : " . $e->getMessage());
            throw new BookUpdateException("Impossible d'ajouter la catégorie au livre");
        }
    }

    public function removeCategoryFromBook(int $bookId, int $categoryId): void
    {
        try {
            $this->bookRepository->removeCategoryFromBook($bookId, $categoryId);
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de catégorie : " . $e->getMessage());
            throw new BookUpdateException("Impossible de retirer la catégorie du livre");
        }
    }

    public function syncBookCategories(int $bookId, array $categoryIds): void
    {
        $this->validateCategoryIds($categoryIds);

        try {
            $this->bookRepository->syncBookCategories($bookId, $categoryIds);
        } catch (PDOException $e) {
            error_log("Erreur lors de la synchronisation des catégories : " . $e->getMessage());
            throw new BookUpdateException("Impossible de synchroniser les catégories");
        }
    }

    public function getAllCategories(): array
    {
        try {
            return $this->categoryRepository->findAll();
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des catégories : " . $e->getMessage());
            return [];
        }
    }


    private function validateBookData(array $data): void
    {
        $errors = [];

        if (empty(trim($data['title'] ?? ''))) {
            $errors[] = "Le titre est obligatoire";
        }

        if (empty(trim($data['author'] ?? ''))) {
            $errors[] = "L'auteur est obligatoire";
        }

        if (!empty($data['isbn']) && !$this->isValidIsbn($data['isbn'])) {
            $errors[] = "Le format ISBN n'est pas valide";
        }

        if (!empty($errors)) {
            throw new InvalidBookDataException(implode(', ', $errors));
        }
    }

    private function validateCategoryIds(array $categoryIds): void
    {
        if (empty($categoryIds)) {
            return;
        }

        // Vérifier que toutes les catégories existent
        $existingCategories = $this->categoryRepository->findByIds($categoryIds);
        $existingIds = array_map(fn($cat) => $cat->getId(), $existingCategories);

        $missingIds = array_diff($categoryIds, $existingIds);
        if (!empty($missingIds)) {
            throw new CategoryNotFoundException(
                "Catégories introuvables : " . implode(', ', $missingIds)
            );
        }
    }

    private function validateCategoryExists(int $categoryId): void
    {
        if (!$this->categoryRepository->findById($categoryId)) {
            throw new CategoryNotFoundException("Catégorie avec l'ID {$categoryId} introuvable");
        }
    }

    private function isValidIsbn(string $isbn): bool
    {
        // Validation simple ISBN (10 ou 13 chiffres avec possibles tirets)
        $isbn = preg_replace('/[-\s]/', '', $isbn);
        return preg_match('/^\d{10}(\d{3})?$/', $isbn);
    }

    //ici BookwithReviews
}