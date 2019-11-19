<?php

namespace App\Core;

use Exception;

/**
 * The core App Class.
 */
class App
{
    /** @type array $registry Contains array of key, values */
    private static $registry = [];

    /**
     * Binds a key, value pair to the App's registry
     * 
     * @param string $key
     * @param mixed $value
     * 
     * @return void
     */
    public static function bind($key, $value)
    {
        static::$registry[$key] = $value;
    }

    /**
     * Returns the registry array
     * 
     * @return array
     */
    public static function getRegistry()
    {
        return static::$registry;
    }
    
    /**
     * Returns an existing registry key's value
     * 
     * @param string $key
     * 
     * @throws Exception if key does not exist 
     * 
     * @return mixed
     */
    public static function get($key)
    {
        if (!array_key_exists($key, static::$registry)) {
            throw new Exception("The {$key} is not bound to the App Container.");
        }

        return static::$registry[$key];
    }
}
