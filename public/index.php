<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Configs\MongoConnection;
use App\Configs\MySqlConnection;
/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va
$router = new AltoRouter();

require __DIR__ . '/../routes/web.php';

$router->map('GET', '/', function () {
    require __DIR__ . '/../app/views/home.tpl.php';
});

// Route avec paramètre
$router->map('GET', '/hello/[a:name]', function ($name) {
    echo "Bonjour, $name !";
});


//$conn = MySqlConnection::getConnection();
//$reviewsData = MongoConnection::getMongoCollection('LibraryLogs', 'reviews');
//var_dump($reviewsData);



// Traitement de la requête
$match = $router->match();

if ($match) {
    $target = $match['target'];

    if (is_array($target) && isset($target['controller'], $target['method'])) {
        $controller = new $target['controller']();

        if (method_exists($controller, $target['method'])) {
            call_user_func_array([$controller, $target['method']], $match['params']);
            exit;
        } else {
            http_response_code(500);
            echo "Méthode du contrôleur non trouvée.";
        }
    } else {
        http_response_code(500);
        echo "Route mal définie.";
    }
} else {
    http_response_code(404);
    echo "Page non trouvée.";
}