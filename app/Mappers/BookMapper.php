<?php

namespace App\Mappers;
use App\Models\Book;

class BookMapper
{
    public static function fromDatabase(array $data): Book
    {
        return new Book($data);
    }

    public static function fromDatabaseMultiple(array $entities): array
    {
        if (empty($entities)) {
            return [];
        }

        return array_map(fn($entity) => self::fromDatabase($entity), $entities);
    }

    public static function entityToBook(array $entity): Book
    {
        return self::fromDatabase($entity);
    }

    public static function entitiesToBooks(array $entities): array
    {
        return self::fromDatabaseMultiple($entities);
    }
}