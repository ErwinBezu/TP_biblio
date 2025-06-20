<?php

use App\Controllers\CategoryController;

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


/* ------------
--- Books ---
-------------*/


/* ------------
--- Users ---
-------------*/