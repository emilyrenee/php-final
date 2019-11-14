<?php

namespace Model;

class Employee extends \Model
{
    protected $servername = "localhost:3306";
    protected $username = "modules";
    protected $password = "secret";
    protected $dbname = "modules";

    function __construct()
    {
        $this->dbConn = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->dbname
        );
    }

    public static function find($id)
    {
        //
    }

    public static function findAll()
    {
        //
    }

    public function validate($data)
    {
        $valid = false;
        
        if ($data && $data->name && $data->address) {
            $valid = true;
        };

        return $valid;
    }

    public function errors()
    {
        // return array of errors
    }

    public function create()
    {
        //
    }

    public function read()
    {
        //
    }

    public function update()
    {
        //
    }

    public function delete()
    {
        //
    }

    public function save($data)
    {
        // first - validate
        $isValid = $this->validate($data);

        if (!$isValid) {
            // return false if not valid
            return false;
        } else {
            // return true or false if insert or update was success
        }
    }

    public function destory()
    {
        //
    }
}
