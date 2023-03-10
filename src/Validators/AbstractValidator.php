<?php

namespace App\Validators;

use Valitron\Validator;

abstract class AbstractValidator

{
    protected $data;
    protected $validator;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;

        $this->validator = new Validator($data);

//       definir les rules ici
//        definir les label ici
    }

    public function validate(): bool
    {
        return $this->validator->validate();
    }

    public function errors(): array
    {
        return $this->validator->errors();
    }
}
