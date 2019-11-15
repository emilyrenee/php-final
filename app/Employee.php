<?php

namespace App;

use App\Core\App;


// all db interactions happen here
class Employee
{
    protected $pdo;

    public function __construct($pdo)
    {

    }

    public static function find($id)
    {
        //
    }

    public static function findAll()
    {   
        $employees = App::get('database')->selectAll('employees');

        return $employees;
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
