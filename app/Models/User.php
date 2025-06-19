<?php
namespace App\Models;

class User
{
    public function __construct(
        private ?int $id,
        private string $name,
        private string $email,
    ){}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function setName(string $name): void{
        $this->name = $name;
    }

    public function setEmail(string $email): void{
        $this->email = $email;
    }

    public function __toString(){
        return "Utilisateur n°$this->id : $this->name email: $this->email";
    }

}