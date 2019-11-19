<?php

namespace App\Controllers;

use App\Employee;
use App\Core\App;
use App\Core\Request;
use App\Repositories\EmployeeRepository;

/**
 * Returns a view file with data
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
 * Redirects to a new location
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
 * // TODO: The Exmployee Controller
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
     * Returns array containing all employees.
     * 
     * @return array
     */
    public function employees()
    {
        return $this->employee->findAll();
    }

    /**
     * Get an employee.
     * Returns array containing the employee
     * that matches id from the request parameter.
     * 
     * @return array
     */
    public function employee()
    {
        $id = Request::params();
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
     * Returns the 'index' view.
     * 
     * @return mixed
     */
    public function delete()
    {
        $data = new \stdClass();
        $data->id = $_POST['id'];
        $this->employee->delete($data);
        return redirect('');
    }

    /**
     * Returns the 'index' view with all exmployees' data
     * 
     * @return mixed
     */
    public function viewAll()
    {
        $employees = $this->employees();
        return view('index', compact('employees'));
    }

    /**
     * Returns the 'view' view with an employee's data
     * 
     * @return mixed
     */
    public function viewEmployee()
    {

        $employee = $this->employee();
        return view('view', compact('employee'));
    }

    /**
     * Returns the 'create' view
     * 
     * @return mixed
     */
    public function viewCreate()
    {
        return view('create');
    }

    /**
     * Returns the 'edit' view with an employee's data
     * 
     * @return mixed
     */
    public function viewEdit()
    {
        $employee = $this->employee();
        return view('edit', compact('employee'));
    }
}
