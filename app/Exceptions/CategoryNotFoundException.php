<?php

namespace App\Exceptions;

use Exception;

class CategoryNotFoundException extends Exception
{
    public function __construct(string $message = "Catégorie introuvable")
    {
        parent::__construct($message);
    }

}