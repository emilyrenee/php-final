<?php

namespace App\Controllers;
use \Model\Employee;

// all db interactions happen here
class EmployeeController
{
    public function index() 
    {
        var_dump('getting to index!');
        $view = new view('../../resources/views/view.html');
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