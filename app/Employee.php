<?php

namespace App;

use App\Interfaces\EmployeeRepositoryInterface;

class Employee
{
    public $error_messages = [];
    protected $employeeStore;

    public function __construct(EmployeeRepositoryInterface $employee)
    {
        $this->employeeStore = $employee;
    }

    public function find($id)
    {

        return $this->employeeStore->find($id);
    }

    public function findAll()
    {
        return $this->employeeStore->findAll();
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

            return $this->employeeStore->create($data, 'insert');
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

            return $this->employeeStore->update($data, 'update');
        }
    }

    public function save(object $data, string $method)
    {
        switch ($method) {
            case 'insert':
                return $this->create($data);
                break;
            case 'update':
                return $this->update($data);
                break;
        }
    }

    public function delete(object $data)
    {
        $data = [
            'id' => $data->id
        ];

        return $this->destroy($data);

    }

    public function destroy(array $data)
    {
        return $this->employeeStore->destroy($data);
    }
}
