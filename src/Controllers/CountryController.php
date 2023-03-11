<?php

namespace App\Controllers;

use App\Model\Country;
use App\Model\Mission;

use App\PaginatedQuery;
use Exception;
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

    public function createCountry(Country $country)
    {
        $id= $this->create([
            'name' => $country->getName(),
            'slug' => $country->getSlug(),
            'nationalities' => $country->getNationalities(),
            'iso3166' => $country->getIso3166()
        ]);
        $country->setId($id);
    }

    /**
     * @throws Exception
     */
    public function findPaginatedCountries()
    {
        $paginatedQuery = new PaginatedQuery(
            "
SELECT * 
FROM $this->table 
",
            "SELECT COUNT($this->table.id) 
FROM $this->table",
            $this->pdo
        );
        $countries = $paginatedQuery->getItems(Country::class);

        return [$countries, $paginatedQuery];
    }
}