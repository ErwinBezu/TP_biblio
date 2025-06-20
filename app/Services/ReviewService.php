<?php

namespace App\Services;

use App\Repositories\ReviewRepository;

class ReviewService
{
    private ReviewRepository $repo;

    public function __construct(ReviewRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllReviews(): array
    {
        return $this->repo->findAll();
    }
}

