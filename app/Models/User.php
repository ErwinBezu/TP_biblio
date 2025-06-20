<?php
namespace App\Models;

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

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): void
    {
        $this->role = $role ?? 'user';
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
        return "Utilisateur n°$this->id : $this->name email: $this->email";
    }

}