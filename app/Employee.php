<?php

namespace App;

use App\Core\App;

class Employee
{
    public $error_messages = [];

    public static function find($id)
    {

        return App::get('database')->selectById('employees', $id);
    }

    public static function findAll()
    {
        return App::get('database')->selectAll('employees');
    }

    public function validate(object $data)
    {
        $valid = false;

        if ($data && $data->name && $data->address) {
            $valid = true;
        }

        return $valid;
    }

    public function errors(object $data)
    {
        $errors = [];

        if (!$data->name) {
            $error = 'Name must be provided.';
            array_push($errors, $error);
        }

        if (!$data->address) {
            $error = 'Address must be provided.';
            array_push($errors, $error);
        }

        $this->error_messages = $errors;

        return $errors;
    }

    public function getErrors()
    {
        return $this->error_messages;
    }


    public function create(object $data)
    {
        $isValid = $this->validate($data);

        if (!$isValid) {
            $this->errors($data);
            return false;
        } else {
            $data = [
                'name' => $data->name,
                'address' => $data->address
            ];

            return $this->save($data, 'insert');
        }
    }

    public function update(object $data)
    {
        $isValid = $this->validate($data);

        if (!$isValid) {
            $this->errors($data);
            return false;
        } else {
            $data = [
                'name' => $data->name,
                'address' => $data->address,
                'id' => $data->id
            ];

            return $this->save($data, 'update');
        }
    }

    public function delete(object $data)
    {
        $data = [
            'id' => $data->id
        ];

        return $this->destroy($data);
    }

    private function save(array $data, string $method)
    {
        $success = false;

        switch ($method) {
            case 'insert':
                $success = App::get('database')->insert('employees', $data);
                break;
            case 'update':
                $success = App::get('database')->update('employees', $data);
                break;
            case 'delete':
                $success = App::get('database')->delete('employees', $data);
                break;
        }

        return $success; 
    }

    private function destroy(array $data)
    {
        return App::get('database')->delete('employees', $data);
    }
}
