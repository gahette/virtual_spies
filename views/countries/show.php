<?php


use App\Model\Country;
use App\Model\Mission;
use App\URL;
use Database\DBConnection;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = (new DBConnection())->getPDO();
$query = $pdo->prepare("SELECT * FROM countries WHERE id = :id");
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Country::class);
/** @var  $country | false */
$country = $query->fetch();

if ($country === false) {
    throw new Exception('Aucune pays ne correspond à cet id');
}


if ($country->getSlug() !== $slug || $country->getId() !== $id) {
    $url = $this->url('country', ['id' => $id, 'slug' => $country->getSlug()]);
    http_response_code(301);
    header('Location: ' . $url);
    exit;
}

$title = "{$country->getName()}";

// Numéro de la page courante
$currentPage = URL::getPositiveInt('page', 1);

// Récupération du nombre de missions
$count = (int)$pdo
    ->query("SELECT COUNT(country_id) FROM country_mission WHERE country_id = {$country->getId()}")
    ->fetch(PDO::FETCH_NUM)[0];

// Nombre d'éléments par page
$perPage = 12;

// Nombre de pages total
$pages = ceil($count / $perPage);
if ($currentPage > $pages) {
    throw new Exception('Cette page n\'existe pas');
}

// Calcul de de l'offset
$offset = $perPage * ($currentPage - 1);

$query = $pdo->query("
SELECT m.*
FROM missions m
JOIN country_mission cm on m.id = cm.mission_id
WHERE cm.country_id = {$country->getId()}
ORDER BY created_at 
DESC LIMIT $perPage OFFSET $offset

    ");
$missions = $query->fetchAll(PDO::FETCH_CLASS, Mission::class);
$link = $this->url('country', ['id' => $country->getId(), 'slug' => $country->getSlug()])

?>


<h1><?= e($country->getName()) ?></h1>

<div class="row">
    <?php foreach ($missions as $mission): ?>
        <div class="col-md-3">
            <?php require dirname(__DIR__) . '/missions/card.php' ?>
        </div>
    <?php endforeach; ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?php if ($currentPage > 1): ?>
        <!--    Suppression du numéro de page dans l'url pour la page 1-->
        <?php
        $l = $link;
        if ($currentPage > 2) $l = $link . '?page=' . ($currentPage - 1);
        ?>
        <a href="<?= $l ?>" class="btn btn-info">&laquo; Page précédente</a>
    <?php endif; ?>
    <?php if ($currentPage < $pages): ?>
        <a href="<?= $link ?>?page=<?= $currentPage + 1 ?>" class="btn btn-info ms-auto">Page suivante
            &raquo;</a>
    <?php endif; ?>
</div>