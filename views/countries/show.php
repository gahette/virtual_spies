<?php


use App\Controllers\CountryController;
use App\Controllers\MissionController;
use App\Model\Country;
use App\Model\Mission;
use App\PaginatedQuery;
use Database\DBConnection;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = (new DBConnection())->getPDO();
$country = (new CountryController($pdo))->find($id);

if ($country->getSlug() !== $slug || $country->getId() !== $id) {
    $url = $this->url('country', ['id' => $id, 'slug' => $country->getSlug()]);
    http_response_code(301);
    header('Location: ' . $url);
    exit;
}

$title = "{$country->getName()}";

[$missions, $paginatedQuery] = (new MissionController($pdo))
    ->findPaginatedForCountry($country->getId());

$link = $this->url('country', ['id' => $country->getId(), 'slug' => $country->getSlug()]);
?>
<h1><?= e($title) ?></h1>

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