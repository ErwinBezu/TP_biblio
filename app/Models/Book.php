<?php
namespace App\Models;

class Book extends BaseModel
{
    private ?string $title = null;
    private ?string $author = null;
    private ?string $isbn = null;
    private array $categories = [];
    private array $borrowers = [];

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): self
    {
        $this->isbn = $isbn;
        return $this;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    public function getBorrowers(): array
    {
        return $this->borrowers;
    }

    public function setBorrowers(array $borrowers): self
    {
        $this->borrowers = $borrowers;
        return $this;
    }

    /**
     * Méthodes utilitaires
     */
    public function addCategory(Category $category): self
    {
        if (!$this->hasCategory($category->getId())) {
            $this->categories[] = $category;
        }
        return $this;
    }

    public function removeCategory(int $categoryId): self
    {
        $this->categories = array_filter($this->categories, function(Category $category) use ($categoryId) {
            return $category->getId() !== $categoryId;
        });
        return $this;
    }

    public function hasCategory(int $categoryId): bool
    {
        foreach ($this->categories as $category) {
            if ($category->getId() === $categoryId) {
                return true;
            }
        }
        return false;
    }

    public function addBorrower(User $user): self
    {
        if (!$this->hasBorrower($user->getId())) {
            $this->borrowers[] = $user;
        }
        return $this;
    }

    public function removeBorrower(int $userId): self
    {
        $this->borrowers = array_filter($this->borrowers, function(User $user) use ($userId) {
            return $user->getId() !== $userId;
        });
        return $this;
    }

    public function hasBorrower(int $userId): bool
    {
        foreach ($this->borrowers as $user) {
            if ($user->getId() === $userId) {
                return true;
            }
        }
        return false;
    }

    public function isAvailable(): bool
    {
        return count($this->borrowers) === 0;
    }

    public function getBorrowerCount(): int
    {
        return count($this->borrowers);
    }

    public function getCategoriesNames(): array
    {
        return array_map(function(Category $category) {
            return $category->getName();
        }, $this->categories);
    }

    /**
     * Validation
     */
    public function validate(): array
    {
        $errors = [];

        if (empty(trim($this->title))) {
            $errors[] = 'Le titre est requis';
        }

        if (empty(trim($this->author))) {
            $errors[] = 'L\'auteur est requis';
        }

        if (!empty($this->isbn) && !$this->isValidISBN($this->isbn)) {
            $errors[] = 'Format ISBN invalide';
        }

        return $errors;
    }

    private function isValidISBN(string $isbn): bool
    {
        $cleanISBN = preg_replace('/[-\s]/', '', $isbn);
        return preg_match('/^\d{10}$|^\d{13}$/', $cleanISBN);
    }

    public function toDatabase(): array
    {
        return [
            'title' => $this->title,
            'author' => $this->author,
            'isbn' => $this->isbn
        ];
    }

    public function toJson(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'isbn' => $this->isbn,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'categories' => array_map(function(Category $cat) { return $cat->toJson(); }, $this->categories),
            'isAvailable' => $this->isAvailable(),
            'borrowerCount' => $this->getBorrowerCount()
        ];
    }
    public function __toString(){
        return "Livre n°$this->id : $this->title dont l'auteur est $this->author qui a pour ISBN $this->isbn";
    }



}