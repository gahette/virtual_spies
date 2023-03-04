<?php


use App\Model\Country;
use App\Model\Mission;
use Database\DBConnection;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = (new DBConnection())->getPDO();
$query = $pdo->prepare("SELECT * FROM missions WHERE id = :id");
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Mission::class);
/** @var  $mission | false */
$mission = $query->fetch();


if($mission === false) {
    throw new Exception('Aucune mission ne correspond à cet id');
}


if($mission->getSlug() !== $slug || $mission->getId() !== $id){
    $url = $this->url('mission', ['id'=>$id, 'slug'=>$mission->getSlug()]);
    http_response_code(301);
    header('Location: ' . $url);
    exit;
}

$title = "{$mission->getTitle()}";

$query = $pdo->prepare("
SELECT c.*
FROM country_mission cm 
JOIN countries c on c.id = cm.country_id
WHERE cm.mission_id = :id");
$query->execute(['id'=>$mission->getId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Country::class);
/** @var  Country[] $countries */
$countries = $query->fetchAll();
?>

<h1 class="card-title"><?= e($mission->getTitle()) ?></h1>
<p class="text-muted"><?= $mission->getCreatedAT()->format('d F Y') ?></p>
<?php foreach ($countries as $country): ?>
<a href="<?= $this->url('country', ['slug'=>$country->getSlug(), 'id' => $country->getId()]) ?>"><?= e($country->getName()) ?></a>
<?php endforeach; ?>
<p><?= nl2br(e($mission->getContent())) ?></p>

<p><a href="<?= $this->url('home') ?>" class="btn btn-dark">Retour</a></p>
