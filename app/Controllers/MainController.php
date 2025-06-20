<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Book;
use App\Models\User;
use App\Models\Users_Books;
use App\Models\Book_Category;

class MainController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
//    public function home(){
//
//        // On appelle la méthode show() de l'objet courant
//        // En argument, on fournit le fichier de Vue
//        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
//        $viewData = [
//            'categories' => $categories,
//            'products' => $products,
//            'brands' => $brands,
//            'types' => $types,
//        ];
//
//        $this->show('main/home', $viewData);
//    }


    public function home()
   {
       echo "La route HOME fonctionne !<br>";
   }

}