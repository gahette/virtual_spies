<?php

use App\Auth;
use App\Controllers\AgentController;
use App\Controllers\CountryController;

use App\HTML\Form;
use App\Model\Agent;

use App\ObjectHelper;
use App\Validators\AgentValidator;

use Database\DBConnection;

Auth::check();

$errors = [];
$agent = new Agent();
$pdo = (new DBConnection)->getPDO();
$countryController = new CountryController($pdo);
$countries = $countryController->list();

if (!empty($_POST)) {

    $agentController = new AgentController($pdo);
    $v = new AgentValidator($_POST, $agentController, $countries, $agent->getId());
    ObjectHelper::hydrate($agent, $_POST, ['lastname', 'bod', 'firstname', 'slug']);
    if ($v->validate()) {
        $pdo->beginTransaction();
        $agentController->createAgent($agent);
        $agentController->attachCountries($agent->getId(),$_POST['countries_ids']);
        $pdo->commit();
        header('Location: ' .$this->url('admin_agent', ['id'=>$agent->getId()]) . '?created=1');
        exit;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($agent, $errors);
?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        L'agent n'a pas pu être enregistré, merci de corriger vos erreurs
    </div>
<?php endif; ?>

<h1>Créer un agent</h1>

<?php require('_form.php') ?>


