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
        $query = $this->pdo->prepare("UPDATE $this->table SET $this->table.title = :title, $this->table.slug = :slug, $this->table.content = :content, $this->table.nickname = :nickname, $this->table.created_at = :created WHERE $this->table.id = :id");
        $updateOk = $query->execute([
            'id'=> $mission->getId(),
            'title'=> $mission->getTitle(),
            'slug'=>$mission->getSlug(),
            'content'=>$mission->getContent(),
            'nickname'=>$mission->getNickname(),
            'created'=>$mission->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        if ($updateOk === false){
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