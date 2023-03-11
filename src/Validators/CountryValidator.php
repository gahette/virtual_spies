<?php

namespace App\Validators;

use App\Controllers\CountryController;


class CountryValidator extends AbstractValidator
{

    /**
     * @param array $data
     * @param CountryController $countryController
     * @param int|null $countryID
     */
    public function __construct(array $data, CountryController $countryController, ?int $countryID = null)
    {
        parent::__construct($data);
        $this->validator->rule('required', 'name', 'slug');
        $this->validator->rule('lengthBetween', ['name', 'slug'], 3, 200);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule(function ($field, $value) use ($countryController, $countryID) {
            return !$countryController->exists($field, $value, $countryID);
        }, ['slug', 'name'], 'est déjà utilisé');
        $this->validator->labels([
            'name' => 'Le pays',
            'slug' => 'Le slug'
        ]);
    }
}