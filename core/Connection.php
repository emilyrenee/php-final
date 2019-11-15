<?php

namespace App\Core;

use PDO;
use PDOException;

class Connection
{
    public static function makeConnection($config)
    {
        var_dump($config['connection'] . ';dbname=' . $config['name']);

        try {
            return new PDO(
                $config['connection'] . ';dbname=' . $config['name'],
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
