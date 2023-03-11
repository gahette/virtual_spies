<?php

use App\Auth;
use App\Controllers\MissionController;
use App\HTML\Form;
use App\ObjectHelper;
use App\Validators\MissionValidator;
use Database\DBConnection;

Auth::check();

$pdo = (new DBConnection)->getPDO();
$missionController = new MissionController($pdo);
$mission = $missionController->find($params['id']);
$success = false;

$errors = [];

if (!empty($_POST)) {
    $v = new MissionValidator($_POST, $missionController, $mission->getId());

    ObjectHelper::hydrate($mission, $_POST, ['title', 'created_at', 'content', 'slug', 'nickname']);
    if ($v->validate()) {
        $missionController->updateMission($mission);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($mission, $errors);
?>
<?php if ($success): ?>
    <div class="alert alert-success">
        La mission a bien été modifié
    </div>
<?php endif; ?>

<?php if (isset($_GET['created'])): ?>
    <div class="alert alert-success">
        La mission a bien été créé
    </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        La mission n'a pas pu être modifié, merci de corriger vos erreurs
    </div>
<?php endif; ?>

<h1>Éditer la mission <?= e($mission->getTitle()) ?></h1>

<?php require ('_form.php') ?>

