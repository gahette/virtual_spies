<?php

namespace App\Controllers;

use App\Controllers\Exception\NotFoundException;
use App\Model\User;
use PDO;


final class UserController extends Controller

{
    protected $table = "users";
    protected $class = User::class;

    public function findByLastname(string $lastname)
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->table WHERE $this->table.lastname = :lastname");
        $query->execute(['lastname' => $lastname]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false) {
            throw new NotFoundException($this->table, $lastname);
        }
        return $result;
}
}