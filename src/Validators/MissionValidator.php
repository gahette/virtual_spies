<?php

namespace App\Validators;

use App\Controllers\MissionController;


class MissionValidator extends AbstractValidator
{

    /**
     * @param array $data
     * @param MissionController $missionController
     * @param int|null $missionID
     * @param array $countries
     */
    public function __construct(array $data, MissionController $missionController, array $countries, ?int $missionID = null)
    {

        parent::__construct($data);
        $this->validator->rule('required', 'title', 'slug');
        $this->validator->rule('lengthBetween', ['title', 'slug'], 3, 200);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule('subset','countries_ids',array_keys($countries));
        $this->validator->rule(function ($field, $value) use ($missionController, $missionID) {
            return !$missionController->exists($field, $value, $missionID);
        }, ['slug', 'title'], 'est déjà utilisé');
        $this->validator->labels([
            'title' => 'Le titre',
            'slug' => 'Le slug',
            'nickname' => 'Le nom de code',
            'content' => 'La description'
        ]);
    }
}