<?php

namespace App\Core;

use PDO;

/**
 * Contruct queries.
 * Execute queries with PDO.
 */
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

    /**
     * Get the id of the last row inserted.
     * 
     * @return int
     */
    public function lastInsert()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Get all rows in a table.
     * 
     * @return array
     */
    public function selectAll(string $table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Get the table rows matching an id.
     * 
     * @param string $table
     * @param int $id
     * 
     * @return array
     */
    public function selectById(string $table, int $id)
    {
        $statement = $this->pdo->prepare("select * from {$table} where id= {$id}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Insert data as a new row into a table.
     * 
     * @param string $table
     * @param array $parameters
     * 
     * @return bool
     */
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

     /**
     * Update a row in a table with data.
     * 
     * @param string $table
     * @param array $parameters
     * 
     * @return bool
     */
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

    /**
     * Delete a row from a table with an id.
     * 
     * @param string $table
     * @param array $parameters
     * 
     * @return bool
     */
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
