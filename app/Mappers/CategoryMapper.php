<?php

namespace App\Mappers;
use App\Models\Category;

class CategoryMapper
{
    public static function fromDatabase(array $data): Category
    {
        return new Category([
            'id' => (int)$data['id'],
            'name' => $data['name'],
        ]);
    }

    public static function fromDatabaseMultiple(array $entities): array
    {
        if (empty($entities)) {
            return [];
        }

        return array_map(fn($entity) => self::fromDatabase($entity), $entities);
    }
}