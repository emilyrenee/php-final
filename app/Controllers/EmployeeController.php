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
    public function index()
    {
        $employees = Employee::findAll();
        $view = view('index', compact('employees'));

        return $view;
    }

    public function employee()
    {
        $id = Request::params();
        $employee = Employee::find($id);
        $view = view('employee', compact('employee'));

        return $view;
    }

    public function viewCreateEmployee()
    {
        $view = view('form');
        return $view;
    }

    public function createEmployee()
    {
        $name = $_POST['name'];
        $address = $_POST['address'];

        $data = new \stdClass();

        $data->name = $name;
        $data->address = $address;

        $employee = Employee::save($data);

        // TODO: return $redirect;
    }
}
