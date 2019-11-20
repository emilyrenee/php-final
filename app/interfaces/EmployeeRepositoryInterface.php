<?php

namespace App\Interfaces;

/**
 * Available CRUD Operations
 */
interface EmployeeRepositoryInterface {
    public function find($id);
    public function create($data);
    public function update($data);
    public function destroy(array $data);
}