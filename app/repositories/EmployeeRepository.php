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
     * Return array containing matching $id.
     * 
     * @param int $id
     * 
     * @return array
     */
    public function find($id)
    {
        return $this->db->selectById('employees', $id);
    }

    /**
     * Find all employees.
     * Returns array containing all employees.
     * 
     * @return array
     */
    public function findAll()
    {
        return $this->db->selectAll('employees');
    }

    /**
     * Creates new employee with data.
     * Returns the success of the operation.
     * 
     * @param object $data
     * 
     * @return bool
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
     * Returns the success of the operation.
     * 
     * @param object $data
     * 
     * @return bool
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
     * Returns the success of the operation.
     * 
     * @param array $data
     * @return bool
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
