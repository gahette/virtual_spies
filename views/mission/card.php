<?php

use App\Auth;

Auth::check();

$countries = [];
foreach ($mission->getCountries() as $country) {
    $url = $this->url('country', ['id' => $country->getId(), 'slug' => $country->getSlug()]);
    $countries[] = <<< HTML
<span class="badge bg-info">
<a href="$url">{$country->getName()}</a>
</span>
HTML;
}


$agents = [];
foreach ($mission->getAgents() as $agent) {
    $url = $this->url('agent', ['id' => $agent->getId(), 'slug' => $agent->getSlug()]);
    $agents[] = <<< HTML
<span class="badge bg-success">
<a href="$url">{$agent->getLastname()}</a>
</span>
HTML;

}

//$query = $pdo->prepare('
//SELECT a.id, a.slug, a.lastname
//FROM agent_mission am
//JOIN agents a on a.id = am.agent_id
//WHERE am.mission_id = :id');
//$query->execute(['id'=>$mission->getId()]);
//$query->setFetchMode(PDO::FETCH_CLASS, \App\Model\Agent::class);
//$agents = $query->fetchAll();

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
            <?php if (!empty($mission->getAgents())): ?>
                <br>::<br>
                <?= implode(' ', $agents) ?>
            <?php endif; ?>
        </p>
        <p><?= $mission->getExcerpt() ?></p>
        <p>
            <a href="<?= $this->url('mission', ['id' => $mission->getId(), 'slug' => $mission->getSlug()]) ?>"
               class="btn btn-dark">Voir plus</a>
        </p>
    </div>
</div>
