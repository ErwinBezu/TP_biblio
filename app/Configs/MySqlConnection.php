<?php

namespace App\Configs;

use PDO;
use PDOException;

class MySqlConnection
{
    private static ?PDO $connection = null;

    private function __construct(){

        $configData = parse_ini_file(__DIR__ . '/../../config.ini');
        if (!$configData) {
            throw new \RuntimeException("Impossible de lire le fichier config.ini");
        }

        try {
            $db = new PDO(
                "mysql:host={$configData['DB_HOST']};dbname={$configData['DB_NAME']};charset=utf8",
                $configData['DB_USERNAME'],
                $configData['DB_PASSWORD'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
            );

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "connection faite";
        } catch (PDOException $e){
            error_log("Erreur de connexion : " . $e->getMessage(), PHP_EOL);
            return; // Ne continue pas si la connexion échoue.
        }
        self::$connection = $db;
//        self::initTable();
    }

    public static function getConnection(): PDO
    {
        if(self::$connection === null){
            new MySqlConnection();
        }

        return self::$connection;
    }

//    private static function initTable(): void{
//        $request = "";
//
//        self::$connection->exec($request);
//    }
}