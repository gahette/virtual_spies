<?php

use App\Controllers\Exception\NotFoundException;
use App\Controllers\UserController;
use App\HTML\Form;
use App\Model\User;
use Database\DBConnection;

$user = new User();
$errors = [];
if (!empty($_POST)) {
    $user->setLastname($_POST['lastname']);
    $errors['password'] = 'Identifiant ou mot de passe incorrect';

    if (!empty($_POST['lastname']) || !empty($_POST['password'])) {
        $table = new UserController((new DBConnection)->getPDO());
        try {
            $u = $table->findByLastname($_POST['lastname']);
            if (password_verify($_POST['password'], $u->getPassword()) === true) {
                session_start();
                $_SESSION['auth'] = $u->getId();
                header('Location: ' . $this->url('admin_missions'));
                exit;
            }
        } catch (NotFoundException $e) {

        }
    }

}

$form = new Form($user, $errors);

?>


<h1>Se connecter</h1>


<?php if (isset($_GET['forbidden'])): ?>
<div class="alert alert-danger">
    Vous ne pouvez pas accéder à cette page !
</div>
<?php endif; ?>

<form action="" method="POST">
    <?= $form->input('lastname', 'Nom d\'utilisateur'); ?>
    <?= $form->input('password', 'Mot de passe'); ?>
    <button type="submit" class="btn btn-dark">Se connecter</button>
</form>