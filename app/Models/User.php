<?php
namespace App\Models;

class User extends BaseModel
{
    private ?string $name = null;
    private ?string $email = null;
    private ?string $password = null;
    private string $role = 'reader';
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role ?? 'reader';
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
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isReader(): bool
    {
        return $this->role === 'reader';
    }

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

    public function getBooksCount(): int
    {
        return count($this->books);
    }

    /**
     * Validation
     */
    public function validate(): array
    {
        $errors = [];

        if (empty(trim($this->name))) {
            $errors[] = 'Le nom est requis';
        }

        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email valide requis';
        }

        if (empty($this->password) || strlen($this->password) < 6) {
            $errors[] = 'Mot de passe requis (minimum 6 caractères)';
        }

        $validRoles = ['user', 'admin', 'librarian'];
        if (!in_array($this->role, $validRoles)) {
            $errors[] = 'Rôle invalide';
        }

        return $errors;
    }

    /**
     * Hash du mot de passe
     */
    public function hashPassword(): self
    {
        if (!empty($this->password)) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
        return $this;
    }

    /**
     * Vérification du mot de passe
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function toDatabase(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role
        ];
    }

    public function toJson(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'BooksCount' => $this->getBooksCount()
        ];
    }
    public function __toString(){
        return "Utilisateur n°$this->id : $this->name email: $this->email";
    }

}