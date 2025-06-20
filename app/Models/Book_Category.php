<?php

namespace App\Models;

class Book_Category extends BaseModel
{
    private ?int $bookId = null;
    private ?int $categoryId = null;

    // Relations optionnelles pour éviter les requêtes supplémentaires
    private ?Book $book = null;
    private ?Category $category = null;

    public function __construct(array $data = [])
    {
        $this->bookId = $data['bookId'] ?? null;
        $this->categoryId = $data['categoryId'] ?? null;
        $this->book = $data['book'] ?? null;
        $this->category = $data['category'] ?? null;

        parent::__construct($data);
    }

    public function getBookId(): ?int
    {
        return $this->bookId;
    }

    public function setBookId(?int $bookId): self
    {
        $this->bookId = $bookId;
        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(?int $categoryId): self
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;
        if ($book) {
            $this->bookId = $book->getId();
        }
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        if ($category) {
            $this->categoryId = $category->getId();
        }
        return $this;
    }

    /**
     * Validation
     */
    public function validate(): array
    {
        $errors = [];

        if (empty($this->bookId)) {
            $errors[] = 'L\'ID du livre est requis';
        }

        if (empty($this->categoryId)) {
            $errors[] = 'L\'ID de la catégorie est requis';
        }

        return $errors;
    }

    /**
     * Clé composite pour identifier uniquement cette relation
     */
    public function getCompositeKey(): string
    {
        return $this->bookId . '-' . $this->categoryId;
    }

    /**
     * Vérifier si cette relation existe déjà
     */
    public function exists(): bool
    {
        return !empty($this->bookId) && !empty($this->categoryId);
    }

    public function toDatabase(): array
    {
        return [
            'bookId' => $this->bookId,
            'categoryId' => $this->categoryId
        ];
    }

    public function toJson(): array
    {
        $json = [
            'bookId' => $this->bookId,
            'categoryId' => $this->categoryId,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt
        ];

        // Inclure les objets liés si disponibles
        if ($this->book) {
            $json['book'] = $this->book->toJson();
        }

        if ($this->category) {
            $json['category'] = $this->category->toJson();
        }

        return $json;
    }
}