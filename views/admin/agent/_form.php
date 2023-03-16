<form action="" method="POST">
    <?= $form->input('lastname', 'Nom'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->input('firstname', 'Prénom'); ?>
    <?= $form->input('bod', 'Date de naissance'); ?>
    <?= $form->select('countries_ids', 'Nationalité', $countries); ?>

    <button class="btn btn-primary mt-4">
        <?php if ($agent->getId() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif; ?>
    </button>
</form>
