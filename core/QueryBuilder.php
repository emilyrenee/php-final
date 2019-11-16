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
    /**
     * Create a new QueryBuilder instance.
     *
     * @param PDO $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    /**
     * Select all records from a database table.
     *
     * @param string $table
     */
    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Select all records from a database table.
     *
     * @param string $table
     */
    public function selectById($table, $id)
    {
        $statement = $this->pdo->prepare("select * from {$table} where id= {$id}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Insert a record into a table.
     *
     * @param  string $table
     * @param  array  $parameters
     */
    public function insert($table, $parameters)
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
     * Updates a record in a table.
     *
     * @param  string $table
     * @param  array  $parameters
     */
    public function update($table, $parameters)
    {
        // UPDATE [LOW_PRIORITY] [IGNORE] table_references
        // SET assignment_list
        // [WHERE where_condition]

        $sql = "update {$table} set name = {$parameters->name}, address = {$parameters->address} where id= {$parameters->id}";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            $id = $this->pdo->lastInsertId();
            return $id;
        } catch (\Exception $e) {
            return false;
        }
    }
}
