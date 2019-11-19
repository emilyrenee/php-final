<?php

namespace App\Interfaces;

interface EmployeeRepositoryInterface {
    public function find($id);
    public function create($data);
    public function update($data);
    public function delete($data);
}