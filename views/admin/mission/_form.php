<form action="" method="POST">
    <?= $form->input('title', 'Titre'); ?>
    <?= $form->input('created_at', 'Date de création'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->input('nickname', 'Nom de code'); ?>
    <?= $form->select('countries_ids', 'Pays', $countries); ?>
    <?= $form->select('agents_ids', 'Les Agents Chargés de la mission', $agents); ?>
    <?= $form->textarea('content', 'Description'); ?>
    <button class="btn btn-primary mt-4">
        <?php if ($mission->getId() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif; ?>
    </button>
</form>
