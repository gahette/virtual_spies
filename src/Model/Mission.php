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
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
//        TODO : remplir slug automatiquement en fonction du title
//        return mb_strtolower(preg_replace(array('/[^a-zA-Z0-9 \'-]/', '/[ -\']+/', '/^-|-$/'),
//            array('', '-', ''), remove_accent($title)));
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
     * @param string $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
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
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }


    /**
     * @return DateTime
     * @throws Exception
     */
    public function getClosedAt(): DateTime
    {
        return new DateTime($this->closed_at);
    }

    /**
     * @param mixed $closed_at
     */
    public function setClosedAt(string $closed_at): self
    {
        $this->closed_at = $closed_at;
        return $this;
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