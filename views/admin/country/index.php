<?php

use App\Auth;
use App\Controllers\CountryController;
use Database\DBConnection;

Auth::check();

$title = "Gestion des pays";
$pdo = (new DBConnection)->getPDO();
$link = $this->url('admin_countries');
//$countries = (new CountryController($pdo))->all();

[$countries, $pagination] = (new CountryController($pdo))->findPaginatedCountries();

?>

<?php if (isset($_GET['delete'])): ?>
    <div class="alert alert-success">
        La mission a bien été supprimer
    </div>
<?php endif; ?>
<table class="table">
    <thead>
    <th>#</th>
    <th>Nom</th>
    <th>URL</th>
    <th>
        <a href="<?= $this->url('admin_country_new') ?>" class="btn btn-primary">Créer un nouveau pays</a>
    </th>
    </thead>
    <tbody>
    <?php foreach ($countries as $country): ?>
        <tr>
            <td>#<?= $country->getId() ?></td>
            <td>
                <a href="<?= $this->url('admin_country', ['id' => $country->getId()]) ?>">
                    <?= e($country->getName()) ?>
                </a>
            </td>
            <td><?= $country->getSlug() ?></td>
            <td>
                <a href="<?= $this->url('admin_country', ['id' => $country->getId()]) ?>" class="btn btn-primary">
                    Modifier
                </a>
                <form action="<?= $this->url('admin_country_delete', ['id' => $country->getId()]) ?>" method="POST"
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