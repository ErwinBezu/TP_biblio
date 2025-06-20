<?php

use App\Controllers\CategoryController;
use App\Controllers\BookController;
use App\Controllers\UserController;

/** @var \AltoRouter $router */
$router->map('GET', '/', [
    'controller' => \App\Controllers\MainController::class,
    'method' => 'home'
], 'main-home');

$router->map('GET', '/test/[a:name]', [
    'controller' => \App\Controllers\MainController::class,
    'method' => 'test'
], 'main-test');


    $router->map('GET', '/books', [
        'controller' => BookController::class,
        'method' => 'index'
    ], 'book-list');


/* ------------
--- Catégories ---
-------------*/


$router->map('GET', '/categories', [
    'controller' => CategoryController::class,
    'method' => 'index'
], 'category-list');

$router->map('GET', '/categories/[i:id]', [
    'controller' => CategoryController::class,
    'method' => 'show'
], 'category-show');



//
//$router->map('GET', '/books', [
//    'controller' => BookController::class,
//    'method' => 'index'
//], 'book-list');

$router->map('GET', '/users', [
    'controller' => UserController::class,
    'method' => 'index'
], 'user-list');