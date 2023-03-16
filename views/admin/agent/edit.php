<?php

use App\Auth;
use App\Controllers\AgentController;
use App\Controllers\CountryController;
use App\HTML\Form;
use App\ObjectHelper;

use App\Validators\AgentValidator;
use Database\DBConnection;

Auth::check();

$pdo = (new DBConnection)->getPDO();
$agentController = new AgentController($pdo);
$countryController = new CountryController($pdo);
$countries = $countryController->listNationalities();
$agent = $agentController->find($params['id']);
$countryController->hydrateAgents([$agent]);
$success = false;

$errors = [];

if (!empty($_POST)) {
    $v = new AgentValidator($_POST, $agentController, $countries, $agent->getId());

    ObjectHelper::hydrate($agent, $_POST, ['lastname', 'slug', 'firstname', 'bod']);
    if ($v->validate()) {
        $pdo->beginTransaction();
        $agentController->updateAgent($agent);
        $agentController->attachCountries($agent->getId(), $_POST['countries_ids']);
        $pdo->commit();
        $countryController->hydrateAgents([$agent]);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($agent, $errors);
?>
<?php if ($success): ?>
    <div class="alert alert-success">
        L'agent a bien été modifié
    </div>
<?php endif; ?>

<?php if (isset($_GET['created'])): ?>
    <div class="alert alert-success">
        L'agent a bien été créé
    </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        L'agent n'a pas pu être modifié, merci de corriger vos erreurs
    </div>
<?php endif; ?>

<h1>Éditer un agent <?= e($agent->getLastname()) ?></h1>

<?php require ('_form.php') ?>

