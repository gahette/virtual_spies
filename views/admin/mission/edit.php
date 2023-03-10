<?php

use App\Controllers\MissionController;
use App\HTML\Form;
use App\Validators\MissionValidator;
use Database\DBConnection;
use Valitron\Validator;

$pdo = (new DBConnection)->getPDO();
$missionController = new MissionController($pdo);
$mission = $missionController->find($params['id']);
$success = false;

$errors = [];

if (!empty($_POST)) {
    Validator::lang('fr');
    $v = new MissionValidator($_POST, $missionController, $mission->getId());

    $mission->setTitle($_POST['title']);
    $mission->setCreatedAt($_POST['created_at']);
    $mission->setContent($_POST['content']);
    $mission->setSlug($_POST['slug']);
    $mission->setNickname($_POST['nickname']);

    if ($v->validate()) {
        $missionController->update($mission);
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

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        La mission n'a pas pu être modifié, merci de corriger vos erreurs
    </div>
<?php endif; ?>

<h1>Éditer la mission <?= e($mission->getTitle()) ?></h1>

<form action="" method="POST">
    <?= $form->input('title', 'Titre'); ?>
    <?= $form->input('created_at', 'Date de création'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->input('nickname', 'Nom de code'); ?>
    <?= $form->textarea('content', 'Description'); ?>
    <button class="btn btn-primary mt-4">Modifier</button>
</form>

