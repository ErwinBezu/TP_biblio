<?php

namespace App\Repositories;

use App\Models\Category;
use Exception;
use PDO;
use App\Configs\MySqlConnection;
use App\Mappers\BookMapper;
use App\Mappers\CategoryMapper;
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

    public function delete(Book $book): Book {
        $sql='DELETE FROM books WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $book->getId(), PDO::PARAM_INT);
        $stmt->execute();
        return $book;
    }

    public function findCategoriesByBookId(int $bookId): array
    {
        $sql = '
            SELECT c.* 
            FROM categories c
            INNER JOIN book_category bc ON c.id = bc.categoryId
            WHERE bc.bookId = :bookId
            ORDER BY c.name
        ';

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['bookId' => $bookId]);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return CategoryMapper::fromDatabaseMultiple($categories);
    }

    public function findBooksByCategoryId(int $categoryId): array
    {
        $sql = '
            SELECT b.* 
            FROM books b
            INNER JOIN book_category  bc ON b.id = bc.bookId
            WHERE bc.categoryId = :categoryId
            ORDER BY b.title
        ';

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['categoryId' => $categoryId]);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return BookMapper::fromDatabaseMultiple($books);
    }

    public function addCategoryToBook(int $bookId, int $categoryId): bool
    {
        $sql = '
            INSERT IGNORE INTO book_category (bookId, categoryId) 
            VALUES (:bookId, :categoryId)
        ';

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'bookId' => $bookId,
            'categoryId' => $categoryId
        ]);
    }

    public function removeCategoryFromBook(int $bookId, int $categoryId): bool
    {
        $sql = 'DELETE FROM book_category WHERE bookId = :bookId AND categoryId = :categoryId';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'bookId' => $bookId,
            'categoryId' => $categoryId
        ]);
    }

    public function syncBookCategories(int $bookId, array $categoryIds): bool
    {
        try {
            $this->db->beginTransaction();

            // Supprimer toutes les catégories actuelles du livre
            $deleteSQL = 'DELETE FROM book_category WHERE bookId = :bookId';
            $deleteStmt = $this->db->prepare($deleteSQL);
            $deleteStmt->execute(['bookId' => $bookId]);

            // Ajouter les nouvelles catégories
            if (!empty($categoryIds)) {
                $insertSQL = 'INSERT INTO book_categories (bookId, categoryId VALUES (:bookId, :categoryId)';
                $insertStmt = $this->db->prepare($insertSQL);

                foreach ($categoryIds as $categoryId) {
                    $insertStmt->execute([
                        'bookId' => $bookId,
                        'categoryId' => $categoryId
                    ]);
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function findBooksWithCategories(): array
    {
        $sql = '
            SELECT 
                b.*,
                GROUP_CONCAT(
                    CONCAT(c.id, ":", c.name) 
                    ORDER BY c.name 
                    SEPARATOR "||"
                ) as categories
            FROM books b
            LEFT JOIN book_category bc ON b.id = bc.bookId
            LEFT JOIN categories c ON bc.categoryId = c.id
            GROUP BY b.id
            ORDER BY b.title
        ';

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $books = [];
        foreach ($results as $row) {
            // CORRECTION: Ne pas passer les catégories au mapper, les traiter séparément
            $bookData = $row;
            unset($bookData['categories']); // Supprimer les catégories des données du livre

            $book = BookMapper::fromDatabase($bookData);

            // Parser les catégories séparément
            $categories = [];
            if (!empty($row['categories'])) {
                $categoryPairs = explode('||', $row['categories']);
                foreach ($categoryPairs as $pair) {
                    if (strpos($pair, ':') !== false) {
                        [$id, $name] = explode(':', $pair, 2);
                        $categories[] = new Category(['id' => (int)$id, 'name' => $name]);
                    }
                }
            }

            $books[] = [
                'book' => $book,
                'categories' => $categories
            ];
        }

        return $books;
    }
}