<form action="" method="POST">
    <?= $form->input('name', 'Nom'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->input('nationalities', 'nationalité'); ?>
    <?= $form->input('iso3166', 'iso3166'); ?>


    <button class="btn btn-primary mt-4">
        <?php if ($country->getId() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif; ?>
    </button>
</form>
