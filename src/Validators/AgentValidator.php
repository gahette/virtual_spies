<?php

namespace App\Validators;

use App\Controllers\AgentController;

class AgentValidator extends AbstractValidator
{
    public function __construct(array $data, AgentController $agentController, array $countries, ?int $agentID = null)
    {

        parent::__construct($data);
        $this->validator->rule('required', 'lastname', 'slug');
        $this->validator->rule('lengthBetween', ['lastname', 'slug'], 3, 200);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule('subset','countries_ids',array_keys($countries));
        $this->validator->rule(function ($field, $value) use ($agentController, $agentID) {
            return !$agentController->exists($field, $value, $agentID);
        }, ['slug', 'lastname'], 'est déjà utilisé');
        $this->validator->labels([
            'lastname' => 'Le nom',
            'slug' => 'Le slug',
            'firstname' => 'Le nom de code'
        ]);
    }
}