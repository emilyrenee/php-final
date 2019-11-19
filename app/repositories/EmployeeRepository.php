<?php

namespace App\Repositories;

use App\Interfaces\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    private $db;

    public function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    public function find($id)
    {
        return $this->db->selectById('employees', $id);
    }

    public function findAll()
    {
        return $this->db->selectAll('employees');
    }

    public function create($data)
    {
        $id = $this->db->insert('employees', $data);

        if ($id) {
            return true;
        }
        return false;
    }

    public function update($data)
    {
        $id = $this->db->update('employees', $data);
        if ($id) {
            return true;
        }
        return false;
    }

    public function destroy(array $data)
    {
        $id = $this->db->delete('employees', $data);

        if ($id) {
            return true;
        }
        return false;
    }
}
