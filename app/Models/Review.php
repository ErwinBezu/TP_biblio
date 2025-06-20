<?php
namespace App\Models;

class Review
{
    public function __construct(
        private ?string $id,
        private int $userId,
        private int $bookId,
        private int $rating,
        private string $comment,
        private \DateTime $read_date,
    ){}

    public function getId(): ?string
    {
        return $this->id;
    }
    public function getUserId(): int
    {
        return $this->userId;
    }
    public function getBookId(): int
    {
        return $this->bookId;
    }
    public function getRating(): int
    {
        return $this->rating;
    }
    public function getComment(): string
    {
        return $this->comment;
    }
    public function getReadDate(): string
    {
        return $this->read_date->format('d-m-Y H:i:s');
    }
    public function setId(?string $id): void
    {
        $this->id = $id;
    }
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
    public function setBookId(int $bookId): void
    {
        $this->bookId = $bookId;
    }
    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }
    public function setReadDate(\DateTime $read_date): void
    {
        $this->read_date = $read_date;
    }

}