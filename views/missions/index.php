<?php
$title = 'Missions';

use App\PaginatedQuery;
use Database\DBConnection;
use App\Model\Mission;

$pdo = (new DBConnection)->getPDO();

$paginatedQuery = new PaginatedQuery(
"SELECT * 
FROM missions 
ORDER BY created_at DESC",
    "SELECT COUNT(id) 
FROM missions"
);

$missions = $paginatedQuery->getItems(Mission::class);
$link = $this->url('home');
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
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>

</div>