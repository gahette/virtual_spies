<?php

namespace App\Model;

class Country
{
    private $id;
    private $name;
    private $slug;
    private $nationalities;
    private $iso3166;

    private $mission_id;

    private $mission;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getNationalities()
    {
        return $this->nationalities;
    }

    /**
     * @return mixed
     */
    public function getIso3166()
    {
        return $this->iso3166;
    }

    public function getMissionId(): ?int
    {
        return $this->mission_id;
    }

    public function setMission(Mission $mission)
    {
        $this->mission = $mission;
    }
}