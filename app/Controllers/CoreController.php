<?php
namespace App\Controllers;

abstract class CoreController
{

    protected function show(string $viewName, $viewData = [])
    {
// Créer une variable $router à partir de l'attribut $this-router
// pour partager le router avec les vues
  //      $router = $this->router;

// Comme $viewData est déclarée comme paramètre de la méthode show()
// les vues y ont accès
// ici une valeur dont on a besoin sur TOUTES les vues
// donc on la définit dans show()
        $viewData['currentPage'] = $viewName;

// définir l'url absolue pour nos assets
  //      $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
// définir l'url absolue pour la racine du site
// /!\ != racine projet, ici on parle du répertoire public/
       // $viewData['baseUri'] = $_SERVER['BASE_URI'];

// On veut désormais accéder aux données de $viewData, mais sans accéder au tableau
// La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewData);
// => la variable $currentPage existe désormais, et sa valeur est $viewName
// => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
// => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
// => il en va de même pour chaque élément du tableau

// $viewData est disponible dans chaque fichier de vue
//        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
//        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }
}
