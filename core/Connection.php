<?php

namespace App\Core;

use PDO;
use PDOException;

class Connection
{
    public static function makeConnection($config)
    {
        try {
            return new PDO(
                $config['connection'] . ';dbname=' . $config['name'],
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            var_dump($e);
            die($e->getMessage());
        }
    }
}
