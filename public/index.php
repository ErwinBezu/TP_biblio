<?php

require_once __DIR__ . '/../vendor/autoload.php';

/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va
$router = new AltoRouter();

$router->map('GET', '/', function () {
    echo "Bienvenue sur la page d'accueil !";
});

// Route avec paramètre
$router->map('GET', '/hello/[a:name]', function ($name) {
    echo "Bonjour, $name !";
});

// Traitement de la requête
$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo "Page non trouvée.";
}