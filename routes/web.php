<?php

use App\Controllers\CategoryController;
use App\Controllers\BookController;
use App\Controllers\UserController;

/* ------------
--- Catégories ---
-------------*/

/** @var \AltoRouter $router */
$router->map('GET', '/categories', [
    'controller' => CategoryController::class,
    'method' => 'index'
], 'category-list');

$router->map('GET', '/categories/[i:id]', [
    'controller' => CategoryController::class,
    'method' => 'show'
], 'category-show');




$router->map('GET', '/books', [
    'controller' => BookController::class,
    'method' => 'index'
], 'book-list');

$router->map('GET', '/users', [
    'controller' => UserController::class,
    'method' => 'index'
], 'user-list');