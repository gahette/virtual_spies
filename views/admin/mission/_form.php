<form action="" method="POST" xmlns="http://www.w3.org/1999/html">
    <?= $form->input('title', 'Titre'); ?>
    <?= $form->input('created_at', 'Date de création'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->input('nickname', 'Nom de code'); ?>
    <?= $form->textarea('content', 'Description'); ?>
    <button class="btn btn-primary mt-4">
        <?php if ($mission->getId() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif; ?>
    </button>
</form>
