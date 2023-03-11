<?php

use App\Auth;
use App\Controllers\CountryController;
use App\HTML\Form;
use App\Model\Country;
use App\ObjectHelper;
use App\Validators\CountryValidator;
use Database\DBConnection;

Auth::check();

$errors = [];
$country = new Country();
if (!empty($_POST)) {
    $pdo = (new DBConnection)->getPDO();
    $countryController = new CountryController($pdo);
    $v = new CountryValidator($_POST, $countryController, $country->getId());
    ObjectHelper::hydrate($country, $_POST, ['name', 'slug', 'nationalities', 'iso3166']);
    if ($v->validate()) {
        $countryController->createCountry($country);
        header('Location: ' .$this->url('admin_country', ['id'=>$country->getId()]) . '?created=1');
        exit;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($country, $errors);

?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        Le pays n'a pas pu être enregistré, merci de corriger vos erreurs
    </div>
<?php endif; ?>

<h1>Créer un pays</h1>

<?php require('_form.php') ?>


