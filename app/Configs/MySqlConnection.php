<?php

namespace src\configs;

use PDO;
use PDOException;

class MySqlConnection
{
    private static string $host = "localhost";
    private static string $db_name = "db_name";
    private static string $username = "username";
    private static string $password = "password";
    private static ?PDO $connection = null;

    private function __construct(){
        try {
            $db = new PDO(
                "mysql:host=". self::$host. ";dbname=". self::$db_name,
                self::$username,
                self::$password
            );

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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