<?php

namespace App\Model;

use DateTime;
use Exception;

class Agent
{
    private $id;
    private string $slug = "";
    private string $lastname = "";
    private string $firstname = "";
    private $bod = "";
    private $picture;

    private array $countries = [];

    private $mission_id;

    private $mission;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getBod(): DateTime
    {
        return new DateTime($this->bod);
    }

    /**
     * @param mixed $bod
     */
    public function setBod(mixed $bod): void
    {
        $this->bod = $bod;
    }

    /**
     * @return Country[]
     */
    public function getCountries(): array
    {
        return $this->countries;
    }

    /**
     * @param array $countries
     */
    public function setCountries(array $countries): void
    {
        $this->countries = $countries;
    }

    public function getCountriesIds(): array
    {
        $ids = [];
        foreach($this->countries as $country){
            $ids[] = $country->getId();
        }
        return $ids;
    }

    public function addCountry(Country $country): void
    {
        $this->countries[] = $country;
        $country->setAgent($this);
    }
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

}