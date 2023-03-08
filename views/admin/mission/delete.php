<?php

use App\Auth;
use App\Controllers\MissionController;
use Database\DBConnection;

Auth::check();

$pdo = (new DBConnection)->getPDO();
$missionController = new MissionController($pdo);
$missionController->delete($params['id']);
header('Location:' .$this->url('admin_missions') . '?delete=1');


?>
<h1>Suppression de <?= $params['id'] ?></h1>