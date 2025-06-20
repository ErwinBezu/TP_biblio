<?php

namespace App\Controllers;

use App\Configs\MongoConnection;
use App\Repositories\ReadingSessionsRepository;
use App\Services\ReadingSessionsService;

class ReadingSessionsController extends CoreController
{
    private ReadingSessionsService $readingSessionsService;

    public function __construct()
    {
        $collection = MongoConnection::getMongoCollection('LibraryLogs', 'readingSessions');
        $reviewRepository = new ReadingSessionsRepository($collection); // Passe la collection à ton repo
        $this->readingSessionsService = new ReadingSessionsService($reviewRepository);
    }

    public function index(): void
    {
        $readingSessions = $this->readingSessionsService->getAllReadingSessions();
        echo "<h2>Contenu de la collection 'readingSessions' :</h2>";
        foreach ($readingSessions as $readingSession) {
            echo '<pre>' . print_r($readingSession, true) . '</pre>';
        };
    }
}