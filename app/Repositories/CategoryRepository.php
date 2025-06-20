<?php

namespace App\Repositories;

use PDO;
use App\Configs\MySqlConnection;
use App\Mappers\CategoryMapper;
use App\Models\Category;

class CategoryRepository
{
    public function __construct(private PDO $db) {
    }

    public function findById(int $id): Category|false {
        $sql = 'SELECT * FROM categories WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute(["id"=> $id]);

        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$category ) {
            return false;
        }
        return CategoryMapper::fromDatabase($category);
    }

    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $sql = "SELECT * FROM categories WHERE id IN ($placeholders) ORDER BY name";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($ids);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return CategoryMapper::fromDatabaseMultiple($categories);
    }

    public function findAll() {
        $sql = 'SELECT * FROM categories';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return CategoryMapper::fromDatabaseMultiple($categories);
    }

    public function create(Category $category): Category {
        $sql= ' INSERT INTO categories (name)
            VALUES (:name)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $category->getName(), PDO::PARAM_STR);
        $stmt->execute();

        $category->setId($this->db->lastInsertId());
        return $category;
    }

    public function update(Category $category): Category
    {
        $sql = 'UPDATE categories SET name = :name WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $category->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $category->getId(), PDO::PARAM_INT);

        $stmt->execute();

        return $category;
    }

    public function delete(Category $category): Category
    {
        $sql = 'DELETE FROM categories WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $category->getId(), PDO::PARAM_INT);

        $stmt->execute();
        return $category;
    }

    public function existsByName(string $name, ?int $excludeId = null): bool
    {
        $sql = 'SELECT COUNT(*) FROM categories WHERE name = :name';
        $params = ['name' => $name];

        if ($excludeId !== null) {
            $sql .= ' AND id != :exclude_id';
            $params['exclude_id'] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchColumn() > 0;
    }
}