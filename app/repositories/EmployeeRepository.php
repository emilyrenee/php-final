<?php

namespace App\Repositories;

use App\Interfaces\EmployeeRepositoryInterface;

/**
 * Implements EmployeeRepositoryInterface
 */
class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     *  The database connection bound to App.
     */
    private $db;

    public function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    /**
     * Find an employee.
     * 
     * @param int $id
     * 
     * @return array Array containing employee that matches $id.
     */
    public function find($id)
    {
        return $this->db->selectById('employees', $id);
    }

    /**
     * Find all employees.
     * 
     * @return array Array containing all employees.
     */
    public function findAll()
    {
        return $this->db->selectAll('employees');
    }

    /**
     * Creates new employee with data.
     * 
     * @param object $data
     * 
     * @return bool The success of the operation.
     */
    public function create($data)
    {
        $id = $this->db->insert('employees', $data);

        if ($id) {
            return true;
        }
        return false;
    }

    /**
     * Updates existing employee with data.
     * 
     * @param object $data
     * 
     * @return bool The success of the operation.
     */
    public function update($data)
    {
        $id = $this->db->update('employees', $data);
        if ($id) {
            return true;
        }
        return false;
    }

    /**
     * Deletes existing employee row.
     * 
     * @param array $data
     * 
     * @return bool The success of the operation.
     */
    public function destroy(array $data)
    {
        $id = $this->db->delete('employees', $data);

        if ($id) {
            return true;
        }
        return false;
    }
}
