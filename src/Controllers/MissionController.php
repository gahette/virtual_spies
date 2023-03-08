<?php

namespace App\Controllers;

use App\Controllers\Exception\NotDeleteException;
use App\Model\Mission;
use App\PaginatedQuery;


class MissionController extends Controller

{
    protected $table = "missions";
    protected $class = Mission::class;

    public function update(Mission $mission): void
    {
        $query = $this->pdo->prepare("UPDATE $this->table SET title = :title  WHERE $this->table.id = :id");
        $deleteOk = $query->execute([
            'id'=> $mission->getId(),
            'title'=> $mission->getTitle()]);
        if ($deleteOk === false){
            throw new NotDeleteException($this->table, $id);
        }
    }
    
    public function delete(int $id): void
    {
       $query = $this->pdo->prepare("DELETE FROM $this->table WHERE $this->table.id = ?");
       $deleteOk = $query->execute([$id]);
       if ($deleteOk === false){
           throw new NotDeleteException($this->table, $id);
       }
    }

    public function findPaginated()
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * 
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