<?php


use App\Router;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

// ====== Chargement du fichier d'autoloading de composer ======
require_once __DIR__ . '/../vendor/autoload.php';

// ====== debugger whoops a commenter pour la mise en production ======
$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

require '../src/helpers.php';

// ====== Numéro de page ======
if (isset($_GET['page']) && $_GET['page'] === 1) {
    // ====== réécrire l'url sans le paramètre ?page ======
    // ====== On commence par séparer l'url par ? et on récupère que la première partie ======
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    // ====== on reconstruit la partie de droite ======
    $get = $_GET;
    unset($get['page']);
    $query = http_build_query($get);
    // ====== On reconstruit l'url ======
    if (!empty($query)) {
        $uri = $uri . '?' . $query;
    }
    header('Location: ' . $uri);
    // ====== url redirigé de façon permanente ======
    http_response_code(301);
    exit;
}

$router = new Router(dirname(__DIR__) . '/views'); // Router qui contient le chemin vers les vue


$router
    ->match('/login', 'auth/login', 'login')
    ->get('/', 'mission/index', 'missions')
    ->get('/country/[*:slug]-[i:id]', 'country/show', 'country')
    ->get('/mission/[*:slug]-[i:id]', 'mission/show', 'mission')

    ->post('/logout','auth/logout', 'logout')
//    ADMIN
//    Gestion des missions
    ->get('/admin/missions', 'admin/mission/index', 'admin_missions')
    ->match('/admin/mission/[i:id]', 'admin/mission/edit', 'admin_mission')
    ->post('/admin/mission/[i:id]/delete', 'admin/mission/delete', 'admin_mission_delete')
    ->match('/admin/mission/new', 'admin/mission/new', 'admin_mission_new')
//    Gestion des pays
    ->get('/admin/countries', 'admin/country/index', 'admin_countries')
    ->match('/admin/country/[i:id]', 'admin/country/edit', 'admin_country')
    ->post('/admin/country/[i:id]/delete', 'admin/country/delete', 'admin_country_delete')
    ->match('/admin/country/new', 'admin/country/new', 'admin_country_new')
//    Gestion des agents
    ->get('/admin/agents','admin/agent/index', 'admin_agents' )
    ->match('/admin/agent/[i:id]', 'admin/agent/edit', 'admin_agent')
    ->post('/admin/agent/[i:id]/delete', 'admin/agent/delete', 'admin_agent_delete')
    ->match('/admin/agent/new', 'admin/agent/new', 'admin_agent_new')

    ->run();

