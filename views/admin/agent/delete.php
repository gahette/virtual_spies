<?php

use App\Auth;
use App\Controllers\AgentController;
use Database\DBConnection;

Auth::check();

$pdo = (new DBConnection)->getPDO();
$agentController = new AgentController($pdo);
$agentController->delete($params['id']);
header('Location:' .$this->url('admin_agents') . '?delete=1');
exit;


?>
<h1>Suppression de <?= $params['id'] ?></h1>