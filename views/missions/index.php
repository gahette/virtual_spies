<?php
$title = 'Missions';

use Database\DBConnection;
use App\Model\Mission;

$pdo = new DBConnection();

// Récupération de la page
$page = $_GET['page'] ?? 1;

// Vérification si le numéro de page est un entier
if(!filter_var($page, FILTER_VALIDATE_INT)){
    throw new Exception('Numéro de page invalide');
}

// Numéro de la page courante
$currentPage = (int)$page;
if ($currentPage <= 0) {
    throw new Exception('Numéro de page invalide');
}

if($page === '1'){
    header('Location: ' . $router->url('home'));
    http_response_code(301);
    exit;
}

// Récupération du nombre de missions
$count = (int)$pdo->getPDO()->query("SELECT COUNT(id) FROM missions")->fetch(PDO::FETCH_NUM)[0];

// Nombre d'éléments par page
$perPage = 12;

// Nombre de pages total
$pages = ceil($count / $perPage);
if ($currentPage > $pages) {
    throw new Exception('Cette page n\'existe pas');
}

// Calcul de de l'offset
$offset = $perPage * ($currentPage - 1);

$query = $pdo->getPDO()->query("SELECT * FROM missions ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
$missions = $query->fetchAll(PDO::FETCH_CLASS, Mission::class);

?>

<h1>Mes missions</h1>


<div class="row">
    <?php foreach ($missions as $mission): ?>
        <div class="col-md-3">
            <?php require 'card.php' ?>
        </div>
    <?php endforeach; ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?php if ($currentPage > 1): ?>
<!--    Suppression du numéro de page dans l'url pour la page 1-->
    <?php
    $link = $router->url('home');
    if ($currentPage > 2) $link .= '?page=' . ($currentPage - 1);
    ?>
        <a href="<?= $link ?>" class="btn btn-info">&laquo; Page précédente</a>
    <?php endif; ?>
    <?php if ($currentPage < $pages): ?>
        <a href="<?= $router->url('home') ?>?page=<?= $currentPage + 1 ?>" class="btn btn-info ms-auto">Page suivante &raquo;</a>
    <?php endif; ?>
</div>