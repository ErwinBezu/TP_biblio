<?php

namespace App\Models;

class Users_Books extends BaseModel
{
    private ?int $bookId = null;
    private ?int $userId = null;
    private string|\DateTimeInterface|null $borrowDate = null;
    private string|\DateTimeInterface|null $returnDate = null;
    private string|\DateTimeInterface|null $dueDate = null;
    private bool $isReturned = false;
    private ?string $notes = null;

    // Relations optionnelles pour éviter les requêtes supplémentaires
    private ?User $user = null;
    private ?Book $book = null;

    public function __construct(array $data = [])
    {
        $this->bookId = $data['bookId'] ?? null;
        $this->userId = $data['userId'] ?? null;
        $this->borrowDate = $data['borrowDate'] ?? $data['createdAt'] ?? date('Y-m-d H:i:s');
        $this->returnDate = $data['returnDate'] ?? null;
        $this->dueDate = $data['dueDate'] ?? null;
        $this->isReturned = (bool)($data['isReturned'] ?? false);
        $this->notes = $data['notes'] ?? null;
        $this->user = $data['user'] ?? null;
        $this->book = $data['book'] ?? null;

        parent::__construct($data);

        // Si pas de date d'échéance, calculer automatiquement (30 jours par défaut)
        if (!$this->dueDate && $this->borrowDate) {
            $this->calculateDueDate();
        }
    }

    // Getters et setters
    public function getBookId(): ?int
    {
        return $this->bookId;
    }

    public function setBookId(?int $bookId): self
    {
        $this->bookId = $bookId;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getBorrowDate(): string|\DateTimeInterface|null
    {
        return $this->borrowDate;
    }

    public function setBorrowDate(string|\DateTimeInterface|null $borrowDate): self
    {
        $this->borrowDate = $borrowDate;
        $this->calculateDueDate();
        return $this;
    }

    public function getReturnDate(): string|\DateTimeInterface|null
    {
        return $this->returnDate;
    }

    public function setReturnDate(string|\DateTimeInterface|null $returnDate): self
    {
        $this->returnDate = $returnDate;
        return $this;
    }

    public function getDueDate(): string|\DateTimeInterface|null
    {
        return $this->dueDate;
    }

    public function setDueDate(string|\DateTimeInterface|null $dueDate): self
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    public function isReturned(): bool
    {
        return $this->isReturned;
    }

    public function setIsReturned(bool $isReturned): self
    {
        $this->isReturned = $isReturned;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        if ($user) {
            $this->userId = $user->getId();
        }
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

    /**
     * Méthodes utilitaires
     */
    private function calculateDueDate(int $borrowDays = 30): void
    {
        if ($this->borrowDate) {
            $borrowDateTime = new DateTime($this->borrowDate);
            $borrowDateTime->add(new DateInterval('P' . $borrowDays . 'D'));
            $this->dueDate = $borrowDateTime->format('Y-m-d H:i:s');
        }
    }

    public function markAsReturned(?string $notes = null): self
    {
        $this->isReturned = true;
        $this->returnDate = date('Y-m-d H:i:s');
        if ($notes) {
            $this->notes = $notes;
        }
        return $this;
    }

    public function extendLoan(int $additionalDays): self
    {
        if ($this->dueDate) {
            $dueDateTime = new DateTime($this->dueDate);
            $dueDateTime->add(new DateInterval('P' . $additionalDays . 'D'));
            $this->dueDate = $dueDateTime->format('Y-m-d H:i:s');
        }
        return $this;
    }

    public function getDaysOverdue(): int
    {
        if ($this->isReturned || !$this->dueDate) {
            return 0;
        }

        $dueDate = new DateTime($this->dueDate);
        $today = new DateTime();

        if ($today <= $dueDate) {
            return 0;
        }

        return $today->diff($dueDate)->days;
    }

    public function isOverdue(): bool
    {
        return $this->getDaysOverdue() > 0;
    }

    public function getDaysBorrowed(): int
    {
        $borrowDate = new DateTime($this->borrowDate);
        $endDate = $this->isReturned ? new DateTime($this->returnDate) : new DateTime();

        return $endDate->diff($borrowDate)->days;
    }

    public function getDaysRemaining(): int
    {
        if ($this->isReturned || !$this->dueDate) {
            return 0;
        }

        $dueDate = new DateTime($this->dueDate);
        $today = new DateTime();

        if ($today >= $dueDate) {
            return 0;
        }

        return $today->diff($dueDate)->days;
    }

    public function getStatus(): string
    {
        if ($this->isReturned) {
            return 'returned';
        }

        if ($this->isOverdue()) {
            return 'overdue';
        }

        if ($this->getDaysRemaining() <= 3) {
            return 'due_soon';
        }

        return 'active';
    }

    /**
     * Clé composite pour identifier uniquement cette relation
     */
    public function getCompositeKey(): string
    {
        return $this->userId . '-' . $this->bookId;
    }

    /**
     * Validation
     */
    public function validate(): array
    {
        $errors = [];

        if (empty($this->userId)) {
            $errors[] = 'L\'ID de l\'utilisateur est requis';
        }

        if (empty($this->bookId)) {
            $errors[] = 'L\'ID du livre est requis';
        }

        if (empty($this->borrowDate)) {
            $errors[] = 'La date d\'emprunt est requise';
        }

        if ($this->returnDate && $this->borrowDate) {
            $borrowDateTime = new DateTime($this->borrowDate);
            $returnDateTime = new DateTime($this->returnDate);

            if ($returnDateTime < $borrowDateTime) {
                $errors[] = 'La date de retour ne peut pas être antérieure à la date d\'emprunt';
            }
        }

        return $errors;
    }

    public function toDatabase(): array
    {
        return [
            'bookId' => $this->bookId,
            'userId' => $this->userId,
            'borrowDate' => $this->borrowDate,
            'returnDate' => $this->returnDate,
            'dueDate' => $this->dueDate,
            'isReturned' => $this->isReturned,
            'notes' => $this->notes
        ];
    }

    public function toJson(): array
    {
        $json = [
            'bookId' => $this->bookId,
            'userId' => $this->userId,
            'borrowDate' => $this->borrowDate,
            'returnDate' => $this->returnDate,
            'dueDate' => $this->dueDate,
            'isReturned' => $this->isReturned,
            'notes' => $this->notes,
            'daysOverdue' => $this->getDaysOverdue(),
            'isOverdue' => $this->isOverdue(),
            'daysBorrowed' => $this->getDaysBorrowed(),
            'daysRemaining' => $this->getDaysRemaining(),
            'status' => $this->getStatus(),
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt
        ];

        // Inclure les objets liés si disponibles
        if ($this->user) {
            $json['user'] = $this->user->toJson();
        }

        if ($this->book) {
            $json['book'] = $this->book->toJson();
        }

        return $json;
    }
}