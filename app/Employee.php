<?php

namespace App;

use App\Interfaces\EmployeeRepositoryInterface;

class Employee
{
    /** @type array $error_message Contains array of known validation errors */
    public $error_messages = [];
    /** @type Employee $employeeStore */
    protected $employeeStore;

    public function __construct(EmployeeRepositoryInterface $employee)
    {
        $this->employeeStore = $employee;
    }

    /**
     * Find an employee
     * 
     * @param int $id
     * 
     * @return array Contains employee matching $id.
     */
    public function find($id)
    {
        return $this->employeeStore->find($id);
    }

    /**
     * Find all employees
     * 
     * @return array Contains all employees.
     */
    public function findAll()
    {
        return $this->employeeStore->findAll();
    }

    /**
     * Determines if data object is valid
     * 
     * @param object $data
     * @return bool The success of the operation. The validity of the data object.
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
     * Sets $error_messages to the validation errors for invalid data object.
     * 
     * @param object $data
     * @return array The validation errrors.
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
     * Get all validation errors.
     * 
     * @return array Contains all validation errors.
     */
    public function getErrors()
    {
        return $this->error_messages;
    }

    /**
     * Creates new employee.
     * Checks if $data is valid.
     * If valid, creates array from $data.
     * 
     * @param object $data
     * 
     * @return bool The success of the operation.
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
     * Updates existing employee.
     * Checks if $data is valid.
     * If valid, creates array from $data.
     * 
     * @param object $data
     * 
     * @return bool The success of the operation.
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
     * Determine whether to update or insert $data by specified $method.
     * Calls the method associated with specified $method.
     * 
     * @param object $data
     * @param string $method
     * 
     * @return bool The success of the operation.
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
     * Deletes existing employee.
     * Checks if $data is valid.
     * If valid, creates array from $data
     * 
     * @param object $data
     * 
     * @return bool The success of the operation.
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
     * 
     * @param array $data
     * 
     * @return bool The success of the operation.
     */
    public function destroy(array $data)
    {
        return $this->employeeStore->destroy($data);
    }
}
