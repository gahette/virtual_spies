<?php

use App\Auth;
use App\Controllers\MissionController;
use App\HTML\Form;
use App\Model\Mission;
use App\ObjectHelper;
use App\Validators\MissionValidator;
use Database\DBConnection;

Auth::check();

$errors = [];
$mission = new Mission();

if (!empty($_POST)) {
    $pdo = (new DBConnection)->getPDO();
    $missionController = new MissionController($pdo);
    $v = new MissionValidator($_POST, $missionController, $mission->getId());
    ObjectHelper::hydrate($mission, $_POST, ['title', 'created_at', 'content', 'slug', 'nickname']);
    if ($v->validate()) {
        $missionController->createMission($mission);
        header('Location: ' .$this->url('admin_mission', ['id'=>$mission->getId()]) . '?created=1');
        exit;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($mission, $errors);
?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        La mission n'a pas pu être enregistré, merci de corriger vos erreurs
    </div>
<?php endif; ?>

<h1>Créer la mission</h1>

<?php require('_form.php') ?>


