<?php
use \Model\Employee;

class EmployeeController
{
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
        $employeeData = $request->all();
        $employee = Employee::save($employeeData);

        $view = new view('../../resources/views/form.html');
        $view->assign('employee', $employee);

        return $view;
    }
}