<?php
namespace App\Models;

class Category
{
    public function __construct(
        private ?int $id,
        private string $name,
    ){}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function setName(string $name): void{
        $this->name = $name;
    }

    public function __toString(){
        return "Categorie n°$this->id : $this->name ";
    }
}