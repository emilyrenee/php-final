<?php

namespace App\Controllers;

use App\Employee;

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

    public function findEmployee(Request $request)
    {
        $id = $request->id;
        $employee = Employee::find($id);

        // $view = new view('../../resources/views/view.html');
        // $view->assign('employee', $employee);

        return;
    }

    public function viewCreateEmployee()
    {
        $view = view('form');
        return $view;
    }

    public function createEmployee()
    {
        var_dump($_POST['name']);
        var_dump($_POST['address']);

        $name = $_POST['name'];
        $address = $_POST['address'];

        $data = new \stdClass();

        $data->name = $name;
        $data->address = $address;

        $employee = Employee::save($data);
        // $employee = Employee::save($employeeData);

        // $view = new view('../../resources/views/form.html');
        // $view->assign('employee', $employee);

        // return $view;
    }
}
