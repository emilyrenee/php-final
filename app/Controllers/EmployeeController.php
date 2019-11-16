<?php

namespace App\Controllers;

use App\Employee;
use App\Core\Request;

/**
 * Require a view.
 *
 * @param  string $name
 * @param  array  $data
 */
function view($name, $data = [])
{
    extract($data);
    return require "/var/www/resources/views/{$name}.php";
}

/**
 * Redirect to a new page.
 *
 * @param  string $path
 */
function redirect($path)
{
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
        // var_dump($id);
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

        $id = Employee::save($data);

        return redirect('view?id=' . $id);
    }

    public function update()
    {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $id = $_POST['id'];

        // var_dump($id);

        $data = new \stdClass();

        $data->name = $name;
        $data->address = $address;
        $data->id = $id;

        $id = Employee::update($data);

        // var_dump($id);
        // update query fails, return false instead of id
        return redirect('view?id=' . $id);
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
        return view('employee', compact('employee'));
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
