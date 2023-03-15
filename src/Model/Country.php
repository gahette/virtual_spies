<?php

namespace App\Model;

class Country
{
    private $id;
    private $name="";
    private $slug="";
    private $nationalities="";
    private $iso3166="";

    private $mission_id;

    private $mission;

    private $agent_id;
    /**
     * @var
     */
    private $agent;

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName( string $name): void
    {
        $this->name = $name;
    }


    /**
     * @return mixed
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getNationalities(): string
    {
        return $this->nationalities;
    }

    /**
     * @param mixed $nationalities
     */
    public function setNationalities(string $nationalities): void
    {
        $this->nationalities = $nationalities;
    }

    /**
     * @return mixed
     */
    public function getIso3166(): string
    {
        return $this->iso3166;
    }

    /**
     * @param mixed $iso3166
     */
    public function setIso3166(string$iso3166): void
    {
        $this->iso3166 = $iso3166;
    }

    /**
     * @return int|null
     */
    public function getMissionId(): ?int
    {
        return $this->mission_id;
    }

    /**
     * @param Mission $mission
     * @return void
     */
    public function setMission(Mission $mission): void
    {
        $this->mission = $mission;
    }

    /**
     * @return int|null
     */
    public function getAgentId(): ?int
    {
        return $this->agent_id;
    }

    /**
     * @param Agent $agent
     * @return void
     */
    public function setAgent(Agent $agent): void
    {
        $this->agent = $agent;
    }


}