<?php
namespace App\Models;

class Book
{
    public function __construct(
        private ?int $id,
        private string $title,
        private string $author,
        private string $isbn,
    ){}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }
    public function getIsbn(): ?string{
        return $this->isbn;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function setTitle(string $title): void{
        $this->title = $title;
    }

    public function setAuthor(string $author){
        $this->author = $author;
    }

    public function setIsbn(string $isbn){
        $this->isbn = $isbn;
    }

    public function __toString(){
        return "Livre n°$this->id : $this->title dont l'auteur est $this->author qui a pour ISBN $this->isbn";
    }

}