<?php
namespace App\Models;

class Category extends BaseModel
{
    private ?string $name = null;
    private array $books = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getBooks(): array
    {
        return $this->books;
    }

    public function setBooks(array $books): self
    {
        $this->books = $books;
        return $this;
    }

    /**
     * Méthodes utilitaires
     */
    public function addBook(Book $book): self
    {
        if (!$this->hasBook($book->getId())) {
            $this->books[] = $book;
        }
        return $this;
    }

    public function removeBook(int $bookId): self
    {
        $this->books = array_filter($this->books, function(Book $book) use ($bookId) {
            return $book->getId() !== $bookId;
        });
        return $this;
    }

    public function hasBook(int $bookId): bool
    {
        foreach ($this->books as $book) {
            if ($book->getId() === $bookId) {
                return true;
            }
        }
        return false;
    }

    public function getBookCount(): int
    {
        return count($this->books);
    }

    public function getAvailableBooks(): array
    {
        return array_filter($this->books, function(Book $book) {
            return $book->isAvailable();
        });
    }

    /**
     * Validation
     */
    public function validate(): array
    {
        $errors = [];

        if (empty(trim($this->name))) {
            $errors[] = 'Le nom de la catégorie est requis';
        }

        return $errors;
    }

    public function toDatabase(): array
    {
        return [
            'name' => $this->name
        ];
    }

    public function toJson(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'bookCount' => $this->getBookCount()
        ];
    }
    public function __toString(){
        return "Categorie n°$this->id : $this->name ";
    }
}