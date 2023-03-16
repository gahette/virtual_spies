<?php

use App\Auth;
use App\Controllers\AgentController;
use Database\DBConnection;


Auth::check();

$title = "Administration des agents";
$pdo = (new DBConnection)->getPDO();
$link = $this->url('admin_agents');


[$agents, $pagination] = (new AgentController($pdo))->findPaginated();

?>

<?php if (isset($_GET['delete'])): ?>
    <div class="alert alert-success">
        L'agent a bien été supprimer
    </div>
<?php endif; ?>
<table class="table">
    <thead>
    <th>#</th>
    <th>Agent</th>
    <th>Prénom</th>
    <th>Nationalité</th>
    <th>Spécialité</th>
    <th>
        <a href="<?= $this->url('admin_agent_new') ?>" class="btn btn-primary">Créer un nouvel agent</a>
    </th>
    </thead>
    <tbody>
    <?php foreach ($agents as $agent): ?>
        <tr>
            <td>#<?= $agent->getId() ?></td>
            <td>
                <a href="<?= $this->url('admin_agent', ['id' => $agent->getId()]) ?>">
                    <?= e($agent->getLastname()) ?>
                </a>
            </td>
            <td>
                <a href="<?= $this->url('admin_agent', ['id' => $agent->getId()]) ?>">
                    <?= e($agent->getFirstname()) ?>
                </a>
            </td>
            <td>

                <a href="<?= $this->url('admin_agent', ['id' => $agent->getId()]) ?>">
                    <?php
                    $countries = [];
                    foreach ($agent->getCountries() as $country) {
                        $url = $this->url('country', ['id' => $country->getId(), 'slug' => $country->getSlug()]);
                        $countries[] = <<< HTML
                        <span><a href="$url">{$country->getNationalities()}</a></span>
                        HTML;
                    }
                    ?>
                    <?php if (!empty($agent->getCountries())): ?>
                        <?= implode(' ', $countries) ?>
                    <?php endif; ?>
                </a>
            </td>
            <td></td>
            <td>
                <a href="<?= $this->url('admin_agent', ['id' => $agent->getId()]) ?>" class="btn btn-primary">
                    Modifier
                </a>
                <form action="<?= $this->url('admin_agent_delete', ['id' => $agent->getId()]) ?>" method="POST"
                      onsubmit="return confirm ('Voulez-vous vraiment effectuer cette action ?')"
                      style="display:inline">
                    <button type="submit" class="btn btn-danger">supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>