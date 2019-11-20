<?php

namespace App\Controllers;

use App\Employee;
use App\Core\App;
use App\Core\Request;
use App\Repositories\EmployeeRepository;

/**
 * Requires and returns a view file with extracted data.
 * 
 * @param string $name
 * @param array $data
 * 
 * @return mixed
 */
function view(string $name, array $data = [])
{
    extract($data);
    return require "/var/www/resources/views/{$name}.php";
}

/**
 * Redirects to location
 * 
 * @param string $path
 * 
 * @return mixed
 */
function redirect(string $path)
{
    header("Location: /{$path}");
}

/**
 *  Returns data and or views for Employee
 */
class EmployeeController
{
    /** @type Employee */
    public $employee;

    public function __construct()
    {
        $this->employee = new Employee(
            new EmployeeRepository(App::get('database'))
        );
    }

    /**
     * Get all employees.
     * 
     * @return array All employees.
     */
    public function employees()
    {
        return $this->employee->findAll();
    }

    /**
     * Get an employee by the request's id param.
     * 
     * @return array Contains employee matching param id. 
     */
    public function employee()
    {
        $id = Request::param('id');
        return $this->employee->find($id);
    }

    /**
     * Create an employee
     * with the POST data.
     * 
     * Returns 'index' view if successful,
     * or return to 'create' view with errors.
     * 
     * @return mixed
     */
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

    /**
     * Update an employee
     * with the POST data.
     * 
     * Returns the 'view' view if successful,
     * or return to 'edit' view with errors.
     * 
     * @return mixed
     */
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

    /**
     * Delete an employee
     * with the POST data id.
     * 
     * @return mixed Redirect to index.
     */
    public function delete()
    {
        $data = new \stdClass();
        $data->id = $_POST['id'];
        $this->employee->delete($data);
        return redirect('');
    }

    /**
     * View all employees.
     * 
     * @return mixed The 'index' view with all exmployees' data.
     */
    public function viewAll()
    {
        $employees = $this->employees();
        return view('index', compact('employees'));
    }

    /**
     * View an employee.
     * 
     * @return mixed The 'view' view with an employee's data.
     */
    public function viewEmployee()
    {

        $employee = $this->employee();
        return view('view', compact('employee'));
    }

    /**
     * View to create new employee.
     * 
     * @return mixed The 'create' view.
     */
    public function viewCreate()
    {
        return view('create');
    }

    /**
     * View to edit existing employee.
     * 
     * @return mixed The 'edit' view with an employee's data.
     */
    public function viewEdit()
    {
        $employee = $this->employee();
        return view('edit', compact('employee'));
    }
}
