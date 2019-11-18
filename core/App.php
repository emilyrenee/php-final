<?php

namespace App\Core;

use Exception;

class App {
    // the registered key, values
    protected static $registry = [];

    // bind a key, value to the container
    public static function bind($key, $value)
    {
        static::$registry[$key] = $value;
    }

    // get a key if exists or throw exception
    public static function get($key)
    {
        if (!array_key_exists($key, static::$registry)) {
            throw new Exception("The {$key} is not bound to the App Container.");
        }

        return static::$registry[$key];
    }
}