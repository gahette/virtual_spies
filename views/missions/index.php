<?php
$title = 'Missions';

use Database\DBConnection;
use App\Model\Mission;

$pdo = new DBConnection();

$query = $pdo->getPDO()->query("SELECT * FROM missions ORDER BY created_at DESC LIMIT 12");
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