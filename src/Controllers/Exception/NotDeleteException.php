<?php

namespace App\Controllers\Exception;

use Exception;

class NotDeleteException extends Exception
{
    public function __construct(string $table, int $id)
    {
        $this->message = "Impossible de supprimer l'enregistrement $id dans la table $table";
    }
}