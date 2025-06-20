<?php

namespace App\Controllers;

use App\Configs\MongoConnection;
use App\Repositories\ReviewRepository;
use App\Services\ReviewService;

class ReviewController extends CoreController
{
    private ReviewService $reviewService;

    public function __construct()
    {
        $collection = MongoConnection::getMongoCollection('LibraryLogs', 'reviews');
        $reviewRepository = new ReviewRepository($collection); // Passe la collection à ton repo
        $this->reviewService = new ReviewService($reviewRepository);
    }

    public function index():void
    {
        //return $this->reviewService->getAllReviews();
        $reviews = $this->reviewService->getAllReviews();
        $this->show('home', ['reviews' => $reviews]);
//        echo "<h2>Contenu de la collection 'reviews' :</h2>";
 //       foreach ($reviews as $review) {
 //       echo '<pre>' . print_r($review, true) . '</pre>';

    }
}

//$collection = MongoConnection::getMongoCollection('LibraryLogs', 'reviews');
//$reviews = $collection->find();
//echo "<h2>Contenu de la collection 'reviews' :</h2>";
//foreach ($reviews as $review) {
         //echo '<pre>' . print_r($review, true) . '</pre>';
//        };
//}