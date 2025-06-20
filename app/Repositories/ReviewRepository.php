<?php

namespace App\Repositories;

use MongoDB\Collection;

class ReviewRepository
{
    private Collection $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function findAll(): array
    {
        return $this->collection->find()->toArray();
    }
}

