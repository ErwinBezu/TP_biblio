<?php

namespace App\Controllers;
use App\Configs\MySqlConnection;
use PDO;

class BookController extends CoreController
{
    public function index()
    {
        $db = MySqlConnection::getConnection();

        $stmt = $db->query("SELECT * FROM books");

        if (!$stmt) {
            die("Erreur dans la requête SQL : " . implode(" - ", $db->errorInfo()));
        }

        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->show('book/index', ['books' => $books]);
    }
}