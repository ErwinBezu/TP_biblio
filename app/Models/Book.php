<?php
namespace App\Models;

namespace App\Models;

class Book extends BaseModel
{
    private ?string $title = null;
    private ?string $author = null;
    private ?string $isbn = null;
    private array $categories = [];

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): void
    {
        $this->isbn = $isbn;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    public function __toString(){
        return "Livre n°$this->id : $this->title dont l'auteur est $this->author qui a pour ISBN $this->isbn";
    }



}