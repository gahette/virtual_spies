<?php

namespace App\Controllers\Exception;

class NotCreateException extends \Exception
{
    public function __construct(string $table)
    {
        $this->message = "Impossible de créer l'enregistrement dans la table $table";
    }
}