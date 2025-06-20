<?php
namespace App\Exceptions;

use Exception;

class BookNotFoundException extends Exception
{
    public function __construct(string $message = "Livre introuvable")
    {
        parent::__construct($message);
    }
}