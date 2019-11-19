<?php

namespace App\Repositories;

use App\Interfaces\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface {
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
        return $this->save($data, 'insert');
    }

    public function update($data)
    {
        return $this->save($data, 'update');
    }


    public function save($data, $method)
    {
        $id;

        switch ($method) {
            case 'insert':
                $id = $this->db->insert('employees', $data);
                break;
            case 'update':
                $id = $this->db->update('employees', $data);
                break;
        }

        if ($id) {
            return true;
        }
        return false;
    }

    public function delete($data)
    {
        return $this->destroy($data);
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