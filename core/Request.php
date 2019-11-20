<?php

namespace App\Core;

class Request
{
    /**
     * Fetch the request URI.
     *
     * @return string
     */
    public static function uri()
    {
        return trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            '/'
        );
    }

    /**
     * Get a request param.
     * 
     * @param string $name
     * 
     * @return string
     */
    public static function param($name)
    {
        return $_GET[$name];
    }

    /**
     * Fetch the request method.
     *
     * @return string
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
