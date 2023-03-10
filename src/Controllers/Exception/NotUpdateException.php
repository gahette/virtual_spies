<?php

namespace App\Controllers\Exception;

use Exception;

class NotUpdateException extends Exception
{
    public function __construct(string $table)
    {
        $this->message = "Impossible de modifier l'enregistrement dans la table $table";
    }
}