<?php

use App\Controllers\CategoryController;
use App\Controllers\BookController;
use App\Controllers\UserController;
use App\Controllers\MainController;


/* ------------
--- books ---
-------------*/
/** @var \AltoRouter $router */
$router->map('GET', '/books', [
    'controller' => \App\Controllers\BookController::class,
    'method' => 'index'
], 'book-list');

// Afficher le formulaire de création
$router->map('GET', '/books/create', [
    'controller' => \App\Controllers\BookController::class,
    'method' => 'create'
], 'book-create-form');

// Traiter la création d'un livre
$router->map('POST', '/books/create', [
    'controller' => BookController::class,
    'method' => 'create'
], 'book-create-process');

// Afficher un livre spécifique
$router->map('GET', '/books/show/[i:id]', [
    'controller' => BookController::class,
    'method' => 'detail'
], 'book-show');

// Afficher le formulaire de modification
$router->map('GET', '/books/edit/[i:id]', [
    'controller' => BookController::class,
    'method' => 'edit'
], 'book-edit-form');

// Traiter la modification d'un livre
$router->map('POST', '/books/edit/[i:id]', [
    'controller' => BookController::class,
    'method' => 'edit'
], 'book-edit-process');

// Afficher la confirmation de suppression
$router->map('GET', '/books/delete/[i:id]', [
    'controller' => BookController::class,
    'method' => 'delete'
], 'book-delete-form');

// Traiter la suppression d'un livre
$router->map('POST', '/books/delete/[i:id]', [
    'controller' => BookController::class,
    'method' => 'delete'
], 'book-delete-process');

// Page d'accueil
$router->map('GET', '/', [
    'controller' => MainController::class,
    'method' => 'home'
], 'main-home');

/* ------------
--- Catégories ---
-------------*/
