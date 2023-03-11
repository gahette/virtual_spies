<?php

namespace App\Controllers;

use App\Controllers\Exception\NotCreateException;
use App\Controllers\Exception\NotDeleteException;
use App\Controllers\Exception\NotFoundException;
use Exception;
use PDO;

abstract class Controller
{
    protected PDO $pdo;
    protected $table = null;
    protected $class = null;

    /**
     * @param PDO $pdo
     * @throws Exception
     */
    public function __construct(PDO $pdo)
    {
        if ($this->table === null){
            throw new Exception("La class " . get_class($this) ." n'a pas de propriété \$table");
        }
        if ($this->class === null){
            throw new Exception("La class " . get_class($this) ." n'a pas de propriété \$class");
        }
        $this->pdo = $pdo;
    }

    /**
     * @throws NotFoundException
     */
    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->table WHERE $this->table.id = :id");
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false) {
            throw new NotFoundException($this->table, $id);
        }
        return $result;
    }

    /**
     * Vérifie si une valeur existe dans la table
     *
     * @param string $field champs à rechercher
     * @param mixed $value valeur associée au champs
     * @param int|null $except
     * @return bool
     */
    public function exists(string $field, mixed $value, ?int $except = null): bool
    {
        $sql = "SELECT COUNT($this->table.id) FROM $this->table WHERE $field = ?";
        $params = [$value];
        if ($except !== null){
            $sql .= " AND id != ?";
                $params[] = $except;
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return $query->fetch(PDO::FETCH_NUM)[0] > 0;
    }

    public function all(): array
    {
        $sql = "SELECT * FROM $this->table";
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
    }
    
    public function delete (int $id)
    {
        $query = $this->pdo->prepare("DELETE FROM $this->table WHERE $this->table.id = ?");
        $deleteOk = $query->execute([$id]);
        if ($deleteOk === false){
            throw new NotDeleteException($this->table, $id);
        }
    }

    public function create(array $data): int
    {
        $sqlFields = [];
        foreach ($data as $key => $value){
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("INSERT INTO $this->table SET " . implode(', ', $sqlFields));
        $updateOk = $query->execute($data);
        if ($updateOk === false){
            throw new NotCreateException($this->table);
        }
        return ((int)$this->pdo->lastInsertId());
    }

    public function update(array $data, int $id)
    {
        $sqlFields = [];
        foreach ($data as $key => $value){
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("UPDATE $this->table SET " . implode(', ', $sqlFields). " WHERE $this->table.id = :id");
        $updateOk = $query->execute(array_merge($data, ['id'=>$id]));
        if ($updateOk === false){
            throw new NotCreateException($this->table);
        }
    }
}