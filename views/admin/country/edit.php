<?php

use App\Auth;
use App\Controllers\CountryController;
use App\HTML\Form;
use App\ObjectHelper;
use App\Validators\CountryValidator;
use Database\DBConnection;


Auth::check();

$pdo = (new DBConnection)->getPDO();
$countryController = new CountryController($pdo);
$country = $countryController->find($params['id']);
$success = false;
$errors = [];
$fields = ['name', 'slug', 'nationalities', 'iso3166'];

if (!empty($_POST)) {
    $v = new CountryValidator($_POST, $countryController, $country->getId());

    ObjectHelper::hydrate($country, $_POST, $fields);
    if ($v->validate()) {
        $countryController->update([
            'name' => $country->getName(),
            'slug' => $country->getSlug(),
            'nationalities' => $country->getNationalities(),
            'iso3166' => $country->getIso3166()
        ], $country->getId());
        $success = true;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($country, $errors);
?>
<?php if ($success): ?>
    <div class="alert alert-success">
        Le pays a bien été modifié
    </div>
<?php endif; ?>

<?php if (isset($_GET['created'])): ?>
    <div class="alert alert-success">
        Le pays a bien été créé
    </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        Le pays n'a pas pu être modifié, merci de corriger vos erreurs
    </div>
<?php endif; ?>

<h1>Éditer le pays <?= e($country->getName()) ?></h1>

<?php require('_form.php') ?>

