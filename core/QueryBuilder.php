<?php

namespace App\Core;

use PDO;

class QueryBuilder
{
    /**
     * The PDO instance.
     *
     * @var PDO
     */
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function lastInsert()
    {
        return $this->pdo->lastInsertId();
    }

    public function selectAll(string $table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(string $table, int $id)
    {
        $statement = $this->pdo->prepare("select * from {$table} where id= {$id}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    public function insert(string $table, array $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
            $id = $this->pdo->lastInsertId();
            return $id;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function update(string $table, array $parameters)
    {
        $name = $parameters['name'];
        $address = $parameters['address'];
        $id = $parameters['id'];
        $sql = 'update ' . $table . ' set name = "' . $name . '", address = "' . $address . '" where id = ' . $id;

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            return $id;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function delete(string $table, array $parameters)
    {
        $id = $parameters['id'];
        $sql = "delete from {$table} where id= {$id}";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            return $id;
        } catch (\Exception $e) {
            return false;
        }
    }
}
