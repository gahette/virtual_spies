<?php

use App\Controllers\MissionController;
use Database\DBConnection;

$pdo = (new DBConnection)->getPDO();
$missionController = new MissionController($pdo);
$mission = $missionController->find($params['id']);
$success = false;

$errors = [];

if (!empty($_POST)) {
    if (empty($_POST['title'])) {
        $errors['title'][] = 'Le champs titre ne peut pas être vide';
    }
    if (mb_strlen($_POST['title']) <= 3) {
        $errors['title'][] = 'Le champs titre doit contenir plus de 3 caractères';
    }
    $mission->setTitle($_POST['title']);
    if (empty($errors)) {
        $missionController->update($mission);
        $success = true;
    }
}

?>
<?php if ($success): ?>
    <div class="alert alert-success">
        La mission a bien été modifié
    </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        L'article n'a pas pu être modifier
    </div>
<?php endif; ?>

<h1>Éditer la mission <?= e($mission->getTitle()) ?></h1>

<form action="" method="POST">
    <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>" name="title"
               value="<?= e($mission->getTitle()) ?>">
        <?php if (isset($errors['title'])): ?>
            <div class="invalid-feedback">
                <?= implode('<br>', $errors['title']) ?>
            </div>
        <?php endif; ?>
    </div>
    <button class="btn btn-primary">Modifier</button>
</form>

