<?php

use App\Controllers\MissionController;
use Database\DBConnection;
use Valitron\Validator;

$pdo = (new DBConnection)->getPDO();
$missionController = new MissionController($pdo);
$mission = $missionController->find($params['id']);
$success = false;

$errors = [];

if (!empty($_POST)) {
    Validator::lang('fr');
    $v = new Validator($_POST);
    $v->labels(array(
        'title' => 'Le titre',
        'content' => 'Contenu'
    ));
    $v->rule('required', 'title');
    $v->rule('lengthBetween', 'title', 3, 200);
    $mission->setTitle($_POST['title']);
    if ($v->validate()) {
        $missionController->update($mission);
        $success = true;
    }else{
  $errors = $v->errors();
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

