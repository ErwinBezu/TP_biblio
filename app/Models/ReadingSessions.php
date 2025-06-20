<?php

namespace App\Models;

class ReadingSessions
{
    public function __construct(
        private string $bookId,
        private int $pagesRead,
        private int $durationMinutes,
        private string $personalNotes,
        private \DateTime $date,
    ) {}

    public function getBookId(): string
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

    public function setBookId(string $bookId): void
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