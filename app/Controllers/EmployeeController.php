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
    var_dump($name);
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
        var_dump('getting to index!');
        $view = view('index');
        var_dump($view);
        return $view;
    }

    public function findEmployee(Request $request)
    {
        $id = $request->id;
        $employee = Employee::find($id);

        $view = new view('../../resources/views/view.html');
        $view->assign('employee', $employee);

        return $view;
    }

    public function createEmployee(Request $request)
    {
        var_dump($_SERVER);
        var_dump($_REQUEST);
        var_dump($_POST['name']);
        var_dump($_POST['address']);
        // $employeeData = $request->all();
        // $employee = Employee::save($employeeData);

        // $view = new view('../../resources/views/form.html');
        // $view->assign('employee', $employee);

        // return $view;
    }
}
