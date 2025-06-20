<?php

namespace App\Factories;

class ModelFactory
{
    public static function createUser(array $data = []): User
    {
        return new User($data);
    }

    public static function createBook(array $data = []): Book
    {
        return new Book($data);
    }

    public static function createCategory(array $data = []): Category
    {
        return new Category($data);
    }

    public static function createBookCategory(array $data = []): BookCategory
    {
        return new BookCategory($data);
    }

    public static function createUserBook(array $data = []): UserBook
    {
        return new UserBook($data);
    }

    /**
     * Créer un utilisateur avec ses livres
     */
    public static function createUserWithBooks(array $userData, array $booksData = []): User
    {
        $user = new User($userData);

        foreach ($booksData as $bookData) {
            $book = new Book($bookData);
            $user->addBook($book);
        }

        return $user;
    }

    /**
     * Créer un livre avec ses catégories
     */
    public static function createBookWithCategories(array $bookData, array $categoriesData = []): Book
    {
        $book = new Book($bookData);

        foreach ($categoriesData as $categoryData) {
            $category = new Category($categoryData);
            $book->addCategory($category);
        }

        return $book;
    }

    /**
     * Créer une catégorie avec ses livres
     */
    public static function createCategoryWithBooks(array $categoryData, array $booksData = []): Category
    {
        $category = new Category($categoryData);

        foreach ($booksData as $bookData) {
            $book = new Book($bookData);
            $category->addBook($book);
        }

        return $category;
    }
}