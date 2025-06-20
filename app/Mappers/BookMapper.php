<?php

namespace App\Mappers;

class BookMapper
{
    public static function entityToBook($entity): Book
    {
        return new Book($entity["id"], $entity["title"], $entity["author"], $entity["isbn"]);
    }

    public static function entitiesToBooks(array $entities): array
    {
        $books = [];
        if(empty($entities))
            return $books;

        foreach($entities as $book){
            $books[] = BookMapper::entityToBook($book);
        }

        return $books;
    }


}