<?php

use App\Auth;
use App\Controllers\CountryController;
use Database\DBConnection;

Auth::check();

$pdo = (new DBConnection)->getPDO();
$countryController = new CountryController($pdo);
$countryController->delete($params['id']);
header('Location:' .$this->url('admin_countries') . '?delete=1');
exit;


?>
<h1>Suppression de <?= $params['id'] ?></h1>