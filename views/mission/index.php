<?php
$title = 'Missions';

use App\Auth;
use App\Controllers\MissionController;
use Database\DBConnection;

Auth::check();

$pdo = (new DBConnection)->getPDO();

$missionController = new MissionController($pdo);
[$missions, $pagination] = $missionController->findPaginated();

$link = $this->url('missions');
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
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>