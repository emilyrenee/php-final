<?php

namespace App\Controllers;

use App\Employee;
use App\Core\App;
use App\Core\Request;
use App\Repositories\EmployeeRepository;

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
    public $employee;

    public function __construct()
    {
        $this->employee = new Employee(
            new EmployeeRepository(App::get('database'))
        );
    }

    public function employees()
    {
        return $this->employee->findAll();
    }

    public function employee()
    {
        $id = Request::params();
        return $this->employee->find($id);
    }

    public function create()
    {
        $data = new \stdClass();
        $data->name = $_POST['name'];
        $data->address = $_POST['address'];
        $success = $this->employee->save($data, 'insert');

        if ($success) {
            return redirect('');
        } else {
            $errors = $this->employee->getErrors();
            return view('create', compact(['errors']));
        }
    }

    public function update()
    {
        $data = new \stdClass();
        $data->name = $_POST['name'];;
        $data->address = $_POST['address'];
        $data->id = $_POST['id'];
        $success = $this->employee->save($data, 'update');

        if ($success) {
            return redirect('view?id=' . $_POST['id']);
        } else {
            $errors = $this->employee->getErrors();
            $employee = $this->employee();
            return view('edit', compact(['employee', 'errors']));
        }
    }

    public function delete()
    {
        $data = new \stdClass();
        $data->id = $_POST['id'];
        $this->employee->delete($data);
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
