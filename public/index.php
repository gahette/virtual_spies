<?php

use App\Router;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

// Chargement du fichier d'autoloading de composer
require_once __DIR__ .'/../vendor/autoload.php';
require '../connect.php';

// debugger whoops a commenter pour la mise en production
$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

$router = new Router(dirname(__DIR__) . '/views'); // Router qui contient le chemin vers les vue


$router
    ->get('/virtual_spies', 'missions/index', 'missions')
    ->get('/virtual_spies/countries', 'countries/show', 'countries')
    ->run();
