<?php

namespace App\Services;
use App\Repositories\ReadingSessionsRepository;

class ReadingSessionsService
{
    private ReadingSessionsRepository $repo;

    public function __construct(ReadingSessionsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllReadingSessions(): array
    {
        return $this->repo->findAll();
    }
}