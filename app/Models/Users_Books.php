<?php
namespace App\Models;
class Users_Books extends BaseModel
{
    private ?int $bookId = null;
    private ?int $userId = null;
    private ?string $notes = null;
    private ?User $user = null;
    private ?Book $book = null;

    public function getBookId(): ?int
    {
        return $this->bookId;
    }

    public function setBookId(?int $bookId): void
    {
        $this->bookId = $bookId;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
        if ($user) {
            $this->userId = $user->getId();
        }
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
}