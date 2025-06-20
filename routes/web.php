<?php

use App\Controllers\CategoryController;
use App\Controllers\BookController;
use App\Controllers\UserController;
use App\Controllers\MainController;
use App\Controllers\ReviewController;
use App\Controllers\ReadingSessionsController;


/* ------------
--- books ---
-------------*/
/** @var \AltoRouter $router */
//$router->map('GET', '/books', [
//    'controller' => \App\Controllers\BookController::class,
//    'method' => 'index'
//], 'book-list');
//
//// Afficher le formulaire de création
//$router->map('GET', '/books/create', [
//    'controller' => \App\Controllers\BookController::class,
//    'method' => 'create'
//], 'book-create-form');
//
//// Traiter la création d'un livre
//$router->map('POST', '/books/create', [
//    'controller' => BookController::class,
//    'method' => 'create'
//], 'book-create-process');
//
//// Afficher un livre spécifique
//$router->map('GET', '/books/show/[i:id]', [
//    'controller' => BookController::class,
//    'method' => 'detail'
//], 'book-show');
//
//// Afficher le formulaire de modification
//$router->map('GET', '/books/edit/[i:id]', [
//    'controller' => BookController::class,
//    'method' => 'edit'
//], 'book-edit-form');
//
//// Traiter la modification d'un livre
//$router->map('POST', '/books/edit/[i:id]', [
//    'controller' => BookController::class,
//    'method' => 'edit'
//], 'book-edit-process');
//
//// Afficher la confirmation de suppression
//$router->map('GET', '/books/delete/[i:id]', [
//    'controller' => BookController::class,
//    'method' => 'delete'
//], 'book-delete-form');
//
//// Traiter la suppression d'un livre
//$router->map('POST', '/books/delete/[i:id]', [
//    'controller' => BookController::class,
//    'method' => 'delete'
//], 'book-delete-process');
//
//// Page d'accueil
$router->map('GET', '/', [
    'controller' => ReadingSessionsController::class,
    'method' => 'index'
], 'main-home');

// Routes pour les livres avec catégories

// === ROUTES LIVRES ===

// Liste des livres
$router->map('GET', '/books', [
    'controller' => BookController::class,
    'method' => 'index'
], 'book-list');

// Formulaire de création d'un livre
$router->map('GET', '/books/create', [
    'controller' => BookController::class,
    'method' => 'create'
], 'book-create-form');

// Traitement de la création d'un livre
$router->map('POST', '/books/create', [
    'controller' => BookController::class,
    'method' => 'create'
], 'book-create');

// Détail d'un livre
$router->map('GET', '/books/[i:id]', [
    'controller' => BookController::class,
    'method' => 'detail'  // ← Changez ici
], 'book-show');

// Formulaire d'édition d'un livre
$router->map('GET', '/books/[i:id]/edit', [
    'controller' => BookController::class,
    'method' => 'edit'
], 'book-edit-form');

// Traitement de la modification d'un livre
$router->map('POST', '/books/[i:id]/edit', [
    'controller' => BookController::class,
    'method' => 'edit'
], 'book-edit');

// Formulaire de confirmation de suppression
$router->map('GET', '/books/[i:id]/delete', [
    'controller' => BookController::class,
    'method' => 'delete'
], 'book-delete-form');

// Traitement de la suppression d'un livre
$router->map('POST', '/books/[i:id]/delete', [
    'controller' => BookController::class,
    'method' => 'delete'
], 'book-delete');

// === ROUTES SPÉCIFIQUES AUX CATÉGORIES DE LIVRES ===

// Ajouter une catégorie à un livre
$router->map('POST', '/books/{bookId}/categories/{categoryId}/add', [
    'controller' => BookController::class,
    'method' => 'addCategory'
], 'book-add-category');

// Retirer une catégorie d'un livre
$router->map('POST', '/books/{bookId}/categories/{categoryId}/remove', [
    'controller' => BookController::class,
    'method' => 'removeCategory'
], 'book-remove-category');

// Afficher les livres d'une catégorie
$router->map('GET', '/books/category/{categoryId}', [
    'controller' => BookController::class,
    'method' => 'byCategory'
], 'books-by-category');

// === ROUTES CATÉGORIES (CRUD COMPLET) ===

// Liste des catégories
$router->map('GET', '/categories', [
    'controller' => CategoryController::class,
    'method' => 'index'
], 'category-list');

// Formulaire de création d'une catégorie
$router->map('GET', '/categories/create', [
    'controller' => CategoryController::class,
    'method' => 'create'
], 'category-create-form');

// Traitement de la création d'une catégorie
$router->map('POST', '/categories/create', [
    'controller' => CategoryController::class,
    'method' => 'create'
], 'category-create');

// Détail d'une catégorie
$router->map('GET', '/categories/{id}', [
    'controller' => CategoryController::class,
    'method' => 'detail'
], 'category-detail');

// Formulaire d'édition d'une catégorie
$router->map('GET', '/categories/{id}/edit', [
    'controller' => CategoryController::class,
    'method' => 'edit'
], 'category-edit-form');

// Traitement de la modification d'une catégorie
$router->map('POST', '/categories/{id}/edit', [
    'controller' => CategoryController::class,
    'method' => 'edit'
], 'category-edit');

// Formulaire de confirmation de suppression
$router->map('GET', '/categories/{id}/delete', [
    'controller' => CategoryController::class,
    'method' => 'delete'
], 'category-delete-form');

// Traitement de la suppression d'une catégorie
$router->map('POST', '/categories/{id}/delete', [
    'controller' => CategoryController::class,
    'method' => 'delete'
], 'category-delete');


/* ------------
--- Catégories ---
-------------*/
