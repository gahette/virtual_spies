<?php


use App\Router;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

// Chargement du fichier d'autoloading de composer
require_once __DIR__ . '/../vendor/autoload.php';

// debugger whoops a commenter pour la mise en production
$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

require '../src/helpers.php';

// Numéro de page
if (isset($_GET['page']) && $_GET['page'] === 1) {
    // réécrire l'url sans le paramètre ?page
    // On commence par séparer l'url par ? et on récupère que la première partie
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    // on reconstruit la partie de droite
    $get = $_GET;
    unset($get['page']);
    $query = http_build_query($get);
    // On reconstruit l'url
    if (!empty($query)) {
        $uri = $uri . '?' . $query;
    }
    header('Location: ' . $uri);
    // url redirigé de façon permanente
    http_response_code(301);
    exit;
}

$router = new Router(dirname(__DIR__) . '/views'); // Router qui contient le chemin vers les vue


$router
    ->get('/', 'mission/index', 'home')
    ->get('/mission/[*:slug]-[i:id]', 'mission/show', 'mission')
    ->get('/country/[*:slug]-[i:id]', 'country/show', 'country')
    ->get('/admin', 'admin/mission/index', 'admin_missions')
    ->match('/admin/mission/[i:id]', 'admin/mission/edit', 'admin_mission')
    ->post('/admin/mission/[i:id]/delete', 'admin/mission/delete', 'admin_mission_delete')
    ->get('/admin/mission/new', 'admin/mission/new', 'admin_mission_new')

    ->run();
