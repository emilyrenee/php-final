<?php

namespace App;

use App\Core\App;

// all db interactions happen here
class Employee
{
    protected $pdo;

    public function __construct($pdo)
    { }

    public static function find($id)
    {

        $employee = App::get('database')->selectById('employees', $id);

        return $employee;
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

    public function update($data)
    {
        // // TODO: validate 
        // var_dump($data);
        $id = App::get('database')->update('employees', [

            'name' => $data->name,
            'address' => $data->address,
            'id' => $data->id
        ]);
        if (!$id) {
            return false; // insert failed
        }
        return $id;
    }

    public function delete()
    {
        //
    }

    public function save($data)
    {
        // first - validate
        $isValid = self::validate($data);

        if (!$isValid) {
            // return false if not valid
            return false;
        } else {
            $id = App::get('database')->insert('employees', [
                'name' => $data->name,
                'address' => $data->address
            ]);
            if (!$id) {
                return false; // insert failed
            }
            return $id;
        }
    }

    public function destory()
    {
        //
    }
}
