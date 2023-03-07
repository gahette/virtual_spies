<?php

namespace App\Controllers;


use App\Model\Country;
use App\Model\Mission;
use PDO;

class CountryController extends Controller
{
    protected $table = "countries";
    protected $class = Country::class;


    /**
     * @param Mission[] $missions
     * @return void
     */
    public function hydrateMissions(array $missions): void
    {
        $missionsByID = [];
        foreach ($missions as $mission) {
            $missionsByID[$mission->getId()] = $mission;
        }
        $countries = $this->pdo
            ->query('SELECT c.*, cm.mission_id
FROM country_mission cm 
JOIN countries c on c.id = cm.country_id
WHERE cm.mission_id IN (' . implode(',', array_keys($missionsByID)) . ')'
            )->fetchAll(PDO::FETCH_CLASS, $this->class);

        foreach ($countries as $country) {
            $missionsByID[$country->getMissionId()]->addCountry($country);
        }
    }
}