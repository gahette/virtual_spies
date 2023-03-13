<?php

use App\Auth;
use App\Controllers\CountryController;
use App\Controllers\MissionController;
use App\HTML\Form;
use App\ObjectHelper;
use App\Validators\MissionValidator;
use Database\DBConnection;

Auth::check();

$pdo = (new DBConnection)->getPDO();
$missionController = new MissionController($pdo);
$countryController = new CountryController($pdo);
$countries = $countryController->list();
$mission = $missionController->find($params['id']);
$countryController->hydrateMissions([$mission]);
$success = false;

$errors = [];

if (!empty($_POST)) {
    $v = new MissionValidator($_POST, $missionController, $countries, $mission->getId());

    ObjectHelper::hydrate($mission, $_POST, ['title', 'created_at', 'content', 'slug', 'nickname']);
    if ($v->validate()) {
        $pdo->beginTransaction();
        $missionController->updateMission($mission);
        $missionController->attachCountries($mission->getId(), $_POST['countries_ids']);
        $pdo->commit();
        $countryController->hydrateMissions([$mission]);
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

