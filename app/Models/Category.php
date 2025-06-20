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

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getBooks(): array
    {
        return $this->books;
    }

    public function setBooks(array $books): void
    {
        $this->books = $books;
    }
    public function __toString(){
        return "Categorie n°$this->id : $this->name ";
    }
}