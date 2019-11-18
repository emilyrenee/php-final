<?php

namespace App\Controllers;

use App\Employee;
use App\Core\Request;

// helpers
function view(string $name, array $data = [])
{
    extract($data);
    return require "/var/www/resources/views/{$name}.php";
}

function redirect(string $path)
{
    // var_dump('calling redriect');
    // ERR_INVALID_REDIRECT
    header("Location: /{$path}");
}

class EmployeeController
{
    public function employees()
    {
        $employees = Employee::findAll();
        return $employees;
    }

    public function employee()
    {
        $id = Request::params();
        $employee = Employee::find($id);

        return $employee;
    }

    public function create()
    {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $data = new \stdClass();
        $data->name = $name;
        $data->address = $address;

        $id = Employee::create($data);

        return redirect('view?id=' . $id);
    }

    public function update()
    {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $id = $_POST['id'];
        $data = new \stdClass();
        $data->name = $name;
        $data->address = $address;
        $data->id = $id;

        $id = Employee::update($data);

        return redirect('view?id=' . $id);
    }

    public function delete()
    {
        $id = $_POST['id'];
        $data = new \stdClass();
        $data->id = $id;
        Employee::delete($data);
        // var_dump($id);
        return redirect('');
    }

    // view methods
    public function viewAll()
    {
        $employees = $this->employees();
        return view('index', compact('employees'));
    }

    public function viewEmployee()
    {

        $employee = $this->employee();
        return view('view', compact('employee'));
    }


    public function viewCreate()
    {
        return view('create');
    }

    public function viewEdit()
    {
        $employee = $this->employee();
        return view('edit', compact('employee'));
    }
}
