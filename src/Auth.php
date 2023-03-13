<?php

namespace App;

use App\Security\ForbiddenException;

class Auth
{
    public static function check(): void
    {
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if (!isset($_SESSION['auth'])){
            throw new ForbiddenException();
        };
    }
}