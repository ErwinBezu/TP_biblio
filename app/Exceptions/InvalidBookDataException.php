<?php

namespace App\Exceptions;

use Exception;

class InvalidBookDataException extends Exception
{
    public function __construct(string $message = "Données du livre invalides")
    {
        parent::__construct($message);
    }
}