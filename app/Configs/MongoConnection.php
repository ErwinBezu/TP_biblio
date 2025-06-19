<?php

namespace src\configs;

use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\Driver\Exception\Exception as MongoDBException;
use MongoDB\Driver\Exception\RuntimeException;

class MongoConnection
{
    private static string $uri = "mongodb://localhost:27017";
    private static ?Client $connection = null;

    private function __construct(){}

    public static function getConnection(): Client
    {
        if(self::$connection === null){
            try{
                self::$connection = new Client(self::$uri);
            } catch (MongoDBException $e){
                throw new RuntimeException("Erreur de connection avec MongoDB: " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    public static function getMongoDB(string $dbName): Database{
        return self::getConnection()->selectDatabase($dbName);
    }

    public static function getMongoCollection(string $dbName, string $collectionName): Collection
    {
        return self::getMongoDB($dbName)->selectCollection($collectionName);
    }

}