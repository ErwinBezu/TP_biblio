<?php

namespace App\Models;

abstract class BaseModel
{
    protected ?int $id = null;
    protected string|\DateTimeInterface|null $createdAt = null;
    protected string|\DateTimeInterface|null $updatedAt = null;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }

    /**
     * Hydrate l'objet avec un tableau de données
     */
    protected function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCreatedAt(): string|\DateTimeInterface|null
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string|\DateTimeInterface|null $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): string|\DateTimeInterface|null
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string|\DateTimeInterface|null $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Validation des données
     */
    abstract public function validate(): array;

    /**
     * Conversion en tableau pour la base de données
     */
    abstract public function toDatabase(): array;

    /**
     * Conversion en JSON
     */
    public function toJson(): array
    {
        return get_object_vars($this);
    }
}