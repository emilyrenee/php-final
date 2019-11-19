<?php

namespace App;

use App\Interfaces\EmployeeRepositoryInterface;

class Employee
{
    /** @type array $error_message Contains array of known validation errors */
    public $error_messages = [];
    /** // TODO: @type mixed $employeeStore Employee Instance */
    protected $employeeStore;

    public function __construct(EmployeeRepositoryInterface $employee)
    {
        $this->employeeStore = $employee;
    }

    /**
     * Returns array containing employee matching $id
     * 
     * @param int $id
     * @return array
     */
    public function find($id)
    {
        return $this->employeeStore->find($id);
    }

    /**
     * Returns array containing all employees
     * 
     * @return array
     */
    public function findAll()
    {
        return $this->employeeStore->findAll();
    }

    /**
     * Determines if data object is valid
     * 
     * @param object $data
     * @return bool
     */
    public function validate(object $data)
    {
        $valid = false;

        if ($data && $data->name && $data->address) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Sets $error_messages to array that contains
     * the validation errors for invalid data object
     * 
     * @param object $data
     * @return array
     */
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

    /**
     * Returns array containing all validation errors
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->error_messages;
    }

    /**
     * Creates new employee
     * Changes $data to array
     * Returns the success of the operation
     * 
     * @param object $data
     * 
     * @return bool
     */
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

    /**
     * Updates existing employee
     * Changes $data to array
     * Returns the success of the operation
     * 
     * @param object $data
     * 
     * @return bool
     */
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

    /**
     * Determine whether to update or insert $data by specified $method
     * Returns the success of the operation
     * 
     * @param object $data
     * @param string $method
     * 
     * @return bool
     */
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

    /**
     * Deletes existing employee
     * Changes $data to array
     * Returns the success of the operation
     * 
     * @param object $data
     * 
     * @return bool
     */
    public function delete(object $data)
    {
        $data = [
            'id' => $data->id
        ];

        return $this->destroy($data);
    }

    /**
     * Deletes existing employee
     * Returns the success of the operation
     * 
     * @param array $data
     * 
     * @return bool
     */
    public function destroy(array $data)
    {
        return $this->employeeStore->destroy($data);
    }
}
