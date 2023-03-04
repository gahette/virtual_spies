<?php

namespace App\Model;

class Country
{
    private $id;
    private $name;
    private $slug;
    private $nationalities;
    private $iso3166;

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



}