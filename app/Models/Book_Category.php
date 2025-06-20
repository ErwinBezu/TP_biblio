<?php

namespace App\Models;

class Book_Category extends BaseModel
{
    private ?int $bookId = null;
    private ?int $categoryId = null;
    private ?Book $book = null;
    private ?Category $category = null;

    public function getBookId(): ?int
    {
        return $this->bookId;
    }

    public function setBookId(?int $bookId): void
    {
        $this->bookId = $bookId;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(?int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): void
    {
        $this->book = $book;
        if ($book) {
            $this->bookId = $book->getId();
        }
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): void
    {
        $this->category = $category;
        if ($category) {
            $this->categoryId = $category->getId();
        }
    }
}