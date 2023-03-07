<?php

namespace App\Controllers;

use App\Model\Mission;
use App\PaginatedQuery;


class MissionController extends Controller

{
protected $table = "missions";
protected $class = Mission::class;

    public function findPaginated()
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * 
FROM missions 
ORDER BY created_at DESC",
            "SELECT COUNT(id) 
FROM missions", $this->pdo
        );
        $missions = $paginatedQuery->getItems(Mission::class);
        (new CountryController($this->pdo))->hydrateMissions($missions);
        return [$missions, $paginatedQuery];
    }

    public function findPaginatedForCountry(int $countryID)
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT m.*
FROM missions m
JOIN country_mission cm on m.id = cm.mission_id
WHERE cm.country_id = {$countryID}
ORDER BY created_at DESC",
            "SELECT COUNT(country_id) 
FROM country_mission 
WHERE country_id = {$countryID}"
        );
        $missions = $paginatedQuery->getItems(Mission::class);
        (new CountryController($this->pdo))->hydrateMissions($missions);
        return [$missions, $paginatedQuery];
    }
}