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
    header("Location: /{$path}");
}

class EmployeeController
{
    
    public function employees()
    {
        return Employee::findAll();
    }

    public function employee()
    {
        $id = Request::params();
        return Employee::find($id);
    }

    public function create()
    {
        $data = new \stdClass();
        $data->name = $_POST['name'];
        $data->address = $_POST['address'];

        $employee = new Employee();
        $success = $employee->create($data);

        if ($success) {
            return redirect('');
        } else {
            $errors = $employee->getErrors();
            return view('create', compact(['errors']));
        }
        
    }

    public function update()
    {
        $data = new \stdClass();
        $data->name = $_POST['name'];;
        $data->address = $_POST['address'];
        $data->id = $_POST['id'];

        $employee = new Employee();
        $success = $employee->update($data);

        if ($success) {
            return redirect('view?id=' . $_POST['id']);
        } else {
            $errors = $employee->getErrors();
            $employee = $this->employee();
            return view('edit', compact(['employee', 'errors']));
        }
    }

    public function delete()
    {
        $data = new \stdClass();
        $data->id = $_POST['id'];

        $employee = new Employee();

        $id = $employee->delete($data);
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
