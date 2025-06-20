<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Book;
use App\Models\User;
use App\Models\Users_Books;
use App\Models\Book_Category;
use App\Configs\MongoConnection;
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
        echo "La route fonctionne tata!<br>";

        $collection = MongoConnection::getMongoCollection('LibraryLogs', 'reviews');
        $reviews = $collection->find(); // <= on récupère les documents ici

        // Le curseur MongoDB contient des objets BSON => on peut les convertir ou les afficher directement
        echo "<h2>Contenu de la collection 'reviews' :</h2>";
        foreach ($reviews as $review) {
            echo '<pre>' . print_r($review, true) . '</pre>';
        };

    }

}