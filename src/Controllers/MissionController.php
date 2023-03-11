<?php

namespace App\Controllers;

use App\Controllers\Exception\NotCreateException;
use App\Controllers\Exception\NotUpdateException;
use App\Model\Mission;
use App\PaginatedQuery;
use Exception;


class MissionController extends Controller

{
    protected $table = "missions";
    protected $class = Mission::class;

    /**
     * @throws NotUpdateException
     * @throws Exception
     */
    public function updateMission(Mission $mission): void
    {
        $this->update([
            'id' => $mission->getId(),
            'title' => $mission->getTitle(),
            'slug' => $mission->getSlug(),
            'content' => $mission->getContent(),
            'nickname' => $mission->getNickname(),
            'created_at' => $mission->getCreatedAt()->format('Y-m-d H:i:s')
        ], $mission->getId());
    }

    /**
     * @throws NotCreateException
     * @throws Exception
     */
    public function createMission(Mission $mission): void
    {
        $id = $this->create([
            'title' => $mission->getTitle(),
            'slug' => $mission->getSlug(),
            'content' => $mission->getContent(),
            'nickname' => $mission->getNickname(),
            'created_at' => $mission->getCreatedAt()->format('Y-m-d H:i:s'),
            'closed_at' => $mission->getClosedAt()->format('Y-m-d H:i:s')
        ]);
        $mission->setId($id);
    }

    /**
     * @throws Exception
     */
    public function findPaginated()
    {
        $paginatedQuery = new PaginatedQuery(
            "
SELECT * 
FROM $this->table 
ORDER BY $this->table.created_at DESC",
            "SELECT COUNT($this->table.id) 
FROM $this->table",
            $this->pdo
        );
        $missions = $paginatedQuery->getItems(Mission::class);
        (new CountryController($this->pdo))->hydrateMissions($missions);
        return [$missions, $paginatedQuery];
    }

    /**
     * @throws Exception
     */
    public function findPaginatedForCountry(int $countryID)
    {
        $paginatedQuery = new PaginatedQuery(
            "
SELECT m.*
FROM missions m
JOIN country_mission cm on m.id = cm.mission_id
WHERE cm.country_id = $countryID
ORDER BY created_at DESC",
            "SELECT COUNT(country_id) 
FROM country_mission 
WHERE country_id = $countryID"
        );
        $missions = $paginatedQuery->getItems(Mission::class);
        (new CountryController($this->pdo))->hydrateMissions($missions);
        return [$missions, $paginatedQuery];
    }
}