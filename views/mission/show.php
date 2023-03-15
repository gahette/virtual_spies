<?php


use App\Auth;
use App\Controllers\MissionController;

use Database\DBConnection;

Auth::check();

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = (new DBConnection())->getPDO();
$mission = (new MissionController($pdo))->find($id);
(new \App\Controllers\CountryController($pdo))->hydrateMissions([$mission]);

if($mission->getSlug() !== $slug || $mission->getId() !== $id){
    $url = $this->url('mission', ['id'=>$id, 'slug'=>$mission->getSlug()]);
    http_response_code(301);
    header('Location: ' . $url);
    exit;
}

$title = "{$mission->getTitle()}";

?>

<h1 class="card-title"><?= e($title) ?></h1>
<p class="text-muted"><?= $mission->getCreatedAT()->format('d F Y') ?></p>
<?php foreach ($mission->getCountries() as $country): ?>
<a href="<?= $this->url('country', ['slug'=>$country->getSlug(), 'id' => $country->getId()]) ?>"><?= e($country->getName()) ?></a>
<?php endforeach; ?>
<p><?= nl2br(e($mission->getContent())) ?></p>

<p><a href="<?= $this->url('missions') ?>" class="btn btn-dark">Retour</a></p>
