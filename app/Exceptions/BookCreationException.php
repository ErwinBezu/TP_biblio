<?php
namespace App\Exceptions;

use Exception;

class BookCreationException extends Exception
{
    public function __construct(string $message = "Erreur lors de la création du livre")
    {
        parent::__construct($message);
    }
}