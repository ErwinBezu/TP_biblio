<?php
namespace App\Exceptions;

use Exception;

class BookDeletionException extends Exception
{
    public function __construct(string $message = "Erreur lors de la suppression du livre")
    {
        parent::__construct($message);
    }
}