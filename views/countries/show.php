<?php


use App\Model\Country;
use App\Model\Mission;
use App\PaginatedQuery;
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

$paginatedQuery = new PaginatedQuery(
    "SELECT m.*
FROM missions m
JOIN country_mission cm on m.id = cm.mission_id
WHERE cm.country_id = {$country->getId()}
ORDER BY created_at DESC",
    "SELECT COUNT(country_id) 
FROM country_mission 
WHERE country_id = {$country->getId()}"
);
/** @var $mission[] */
$missions = $paginatedQuery->getItems(Mission::class);
$link = $this->url('country', ['id' => $country->getId(), 'slug' => $country->getSlug()]);
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
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>
</div>