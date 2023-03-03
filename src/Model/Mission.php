<?php

namespace App\Model;

use DateTime;
use App\Helpers\Text;

class Mission
{
    private int $id;
    private string $title;
    private string $slug;
    private string $content;
    private string $nickname;
    private $created_at;
    private $closed_at;

    private $countries = [];

    /**
     * @return int
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
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    /**
     * @return DateTime
     */
    public function getClosedAt(): DateTime
    {
        return new DateTime($this->closed_at);
    }

    public function getExcerpt(): ?string
    {
        if ($this->content === null) {
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content, 60)));
    }

    /**
     * @return array
     */
    public function getCountries(): array
    {
        return $this->countries;
    }


}