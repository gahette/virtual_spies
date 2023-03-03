<div class="card mb-3">
    <div class="card-body">
        <!--        htmlentities pour éviter à l'utilisateur de mettre de l'HTML-->
        <h5 class="card-title"><?= htmlentities($mission->getTitle()) ?></h5>
        <p class="text-muted"><?= $mission->getCreatedAT()->format('d F Y') ?></p>
        <p><?= $mission->getExcerpt() ?></p>
        <p>
            <a href="<?= $router->url('mission', ['id' => $mission->getId(), 'slug'=>$mission->getSlug()]) ?>" class="btn btn-dark">Voir plus</a>
        </p>
    </div>
</div>
