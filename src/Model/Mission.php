<?php

namespace App\Model;

use DateTime;
use App\Helpers\Text;
use Exception;

class Mission
{
    private int $id;
    private string $title;
    private string $slug;
    private string $content;
    private string $nickname;
    private $created_at;
    private $closed_at;

    private array $countries = [];

    /**
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Mission
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }


    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getClosedAt(): DateTime
    {
        return new DateTime($this->closed_at);
    }

    public function getExcerpt(): ?string
    {
        return nl2br(htmlentities(Text::excerpt($this->content)));
    }

    /**
     * @return Country[]
     */
    public function getCountries(): array
    {
        return $this->countries;
    }

    public function addCountry(Country $country): void
    {
        $this->countries[] = $country;
        $country->setMission($this);
    }

}