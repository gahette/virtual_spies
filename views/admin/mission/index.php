<?php

use App\Controllers\MissionController;
use Database\DBConnection;

$title = "Administration";
$pdo = (new DBConnection)->getPDO();
$link = $this->url('admin_missions');

[$missions, $pagination] = (new MissionController($pdo))->findPaginated();

?>

<?php if (isset($_GET['delete'])): ?>
    <div class="alert alert-success">
        La mission a bien été supprimer
    </div>
<?php endif; ?>
<table class="table">
    <thead>
    <th>#</th>
    <th>Titre</th>
    <th>Actions</th>
    </thead>
    <tbody>
    <?php foreach ($missions as $mission): ?>
        <tr>
            <td>#<?= $mission->getId() ?></td>
            <td>
                <a href="<?= $this->url('admin_mission', ['id' => $mission->getId()]) ?>">
                    <?= e($mission->getTitle()) ?>
                </a>
            </td>
            <td>
                <a href="<?= $this->url('admin_mission', ['id' => $mission->getId()]) ?>" class="btn btn-primary">
                    Editer
                </a>
                <form action="<?= $this->url('admin_mission_delete', ['id' => $mission->getId()]) ?>" method="POST"
                      onsubmit="return confirm ('Voulez-vous vraiment effectuer cette action ?')" style="display:inline">
                    <button type="submit" class="btn btn-danger">supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>