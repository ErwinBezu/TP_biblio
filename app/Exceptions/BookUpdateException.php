<?php

namespace App\Exceptions;

use Exception;

class BookUpdateException extends Exception
{
    public function __construct(string $message = "Erreur lors de la modification du livre")
    {
        parent::__construct($message);
    }
}