<?php

namespace App;

use App\Core\App;

class Employee
{
    public static function find($id)
    {

        return App::get('database')->selectById('employees', $id);
    }

    public static function findAll()
    {
        return App::get('database')->selectAll('employees');
    }

    // TODO: need to check id, update, delete
    public function validate(object $data)
    {
        $valid = false;

        if ($data && $data->name && $data->address) {
            $valid = true;
        };

        return $valid;
    }

    public function errors()
    {
        // TODO:
        // return array of errors
    }

    public function create(object $data)
    {
        $isValid = self::validate($data);

        if (!$isValid) {
            // TODO: return error
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

    public function update(object $data)
    {
        $isValid = self::validate($data);

        if (!$isValid) {
            // TODO: return error
            return false;
        } else {
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
    }

    public function delete(object $data)
    {
        $id = App::get('database')->delete('employees', [
            'id' => $data->id
        ]);
        if (!$id) {
            return false; // insert failed
        }
        return $id;
    }
}
