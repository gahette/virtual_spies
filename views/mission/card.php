<?php
$countries = [];
foreach ($mission->getCountries() as $country) {
    $url = $this->url('country', ['id' => $country->getId(), 'slug' => $country->getSlug()]);
    $countries[] = <<< HTML
<span class="badge bg-info">
<a href="$url">{$country->getName()}</a>
</span>
HTML;
}
?>

<div class="card mb-3">

    <div class="card-body">
        <!--        htmlentities pour éviter à l'utilisateur de mettre de l'HTML-->
        <h5 class="card-title"><?= htmlentities($mission->getTitle()) ?></h5>
        <p class="text-muted">
            <?= $mission->getCreatedAT()->format('d F Y') ?>
            <?php if (!empty($mission->getCountries())): ?>
                <br>::<br>
                <?= implode(' ', $countries) ?>
            <?php endif; ?>
        </p>
        <p><?= $mission->getExcerpt() ?></p>
        <p>
            <a href="<?= $this->url('mission', ['id' => $mission->getId(), 'slug' => $mission->getSlug()]) ?>"
               class="btn btn-dark">Voir plus</a>
        </p>
    </div>
</div>
