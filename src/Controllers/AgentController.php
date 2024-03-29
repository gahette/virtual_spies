<?php

namespace App\Controllers;

use App\Controllers\Exception\NotCreateException;
use App\Model\Agent;
use App\PaginatedQuery;
use Exception;
use PDO;

class AgentController extends Controller
{
    protected $table = "agents";
    protected $class = Agent::class;

    public function hydrateMissions(array $missions): void
    {
        $missionsByID = [];
        foreach ($missions as $mission) {
            $mission->setAgents([]);
            $missionsByID[$mission->getId()] = $mission;
        }
        $agents = $this->pdo
            ->query('SELECT a.*, am.mission_id
FROM agent_mission am 
JOIN agents a on a.id = am.agent_id
WHERE am.mission_id IN (' . implode(',', array_keys($missionsByID)) . ')'
            )->fetchAll(PDO::FETCH_CLASS, $this->class);

        foreach ($agents as $agent) {
            $missionsByID[$agent->getMissionId()]->addAgent($agent);
        }
    }

    /**
     * @param Agent $agent
     * @return void
     * @throws NotCreateException
     */
    public function updateAgent(Agent $agent): void
    {
        $this->update([
            'slug' => $agent->getSlug(),
            'lastname' => $agent->getLastname(),
            'firstname' => $agent->getLastname(),
            'bod' => $agent->getBod()->format('Y-m-d H:i:s')
        ], $agent->getId());
    }

    /**
     * @throws NotCreateException
     * @throws Exception
     */
    public function createAgent(Agent $agent): void
    {
        $id = $this->create([

            'slug' => $agent->getSlug(),
            'lastname' => $agent->getLastname(),
            'firstname' => $agent->getLastname(),
            'bod' => $agent->getBod()->format('Y-m-d H:i:s')
        ]);
        $agent->setId($id);
    }

    public function attachCountries(int $id, array $countries)
    {
        $this->pdo->exec('DELETE FROM country_agent WHERE agent_id = ' . $id);
        $query = $this->pdo->prepare('INSERT INTO country_agent SET agent_id = ?, country_id = ? ');
        foreach ($countries as $country){
            $query->execute([$id, $country]);
        }
    }

    /**
     * @throws Exception
     */
    public function findPaginated(): array
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
        $agents = $paginatedQuery->getItems(Agent::class);
        (new CountryController($this->pdo))->hydrateAgents($agents);
        return [$agents, $paginatedQuery];
    }

    /**
     * @throws Exception
     */
    public function findPaginatedForCountry(int $countryID): array
    {
        $paginatedQuery = new PaginatedQuery(
            "
SELECT a.*
FROM agents a
JOIN country_agent ca on a.id = ca.agent_id
WHERE ca.country_id = $countryID
",
            "SELECT COUNT(country_id) 
FROM country_agent 
WHERE country_id = $countryID"
        );
        $agents = $paginatedQuery->getItems(Agent::class);
        (new CountryController($this->pdo))->hydrateAgents($agents);
        return [$agents, $paginatedQuery];
    }
    public function list(): array
    {
        $agents = $this->all();
        $results = [];
        foreach ($agents as $agent){
            $results[$agent->getId()] = $agent->getLastname();
        }
        return $results;
    }

}
// TODO :ORDER BY $this->table.created_at DESC à voir pour findPaginated()