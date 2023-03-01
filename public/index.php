<?php
// Chargement du fichier d'autoloading de composer
require '../vendor/autoload.php';

// Démarrage du router
$router = new AltoRouter();


// Constante qui contient le chemin vers les vue
define('VIEW_PATH', dirname(__DIR__) . '/views');

// Gestion des URL
$router->map('GET', '/missions', function (){
    require VIEW_PATH . '/missions/index.php';
});
$router->map('GET', '/missions/countries', function (){
    require VIEW_PATH . '/countries/show.php';
});

// Demande au router si URL correspond au routes
$match = $router->match();
$match['target']();
