<?php

namespace App\Models;

class ReadingSessions
{
    public function __construct(
        private ?string $id,
        private int $userId,
        private int $bookId,
        private int $pagesRead,
        private int $durationMinutes,
        private string $personalNotes,
        private \DateTime $date,
    ) {}

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

    public function getPagesRead(): int
    {
        return $this->pagesRead;
    }

    public function getDurationMinutes(): int
    {
        return $this->durationMinutes;
    }

    public function getPersonalNotes(): string
    {
        return $this->personalNotes;
    }

    public function getDate(): string
    {
        return $this->date->format('d-m-Y H:i:s');
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

    public function setPagesRead(int $pagesRead): void
    {
        $this->pagesRead = $pagesRead;
    }

    public function setDurationMinutes(int $durationMinutes): void
    {
        $this->durationMinutes = $durationMinutes;
    }

    public function setPersonalNotes(string $personalNotes): void
    {
        $this->personalNotes = $personalNotes;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }
}