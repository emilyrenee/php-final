<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Faker;
use App\Employee;

use App\Core\App;
use App\Core\{QueryBuilder, Connection};


class EmployeeTest extends TestCase
{
    public $faker;
    public $employee;
    public $name = 'Tester Test';
    public $address = 'Test Street';
    public $id;
    public $rowCount;

    public function setUp(): void
    {
        // db connection
        App::bind('config', require '../config.php');
        App::bind('database', new QueryBuilder(
            Connection::makeConnection(App::get('config')['database'])
        ));

        // fixture object
        $this->faker = Faker\Factory::create();
        $this->faker->name = $this->name;
        $this->faker->address = $this->address;

        $this->employee = new Employee();
        $this->employee->save([
            'name' => $this->faker->name,
            'address' => $this->faker->address
        ], 'insert');

        $this->id = App::get('database')->lastInsert();
        $this->rowCount = (count(App::get('database')->selectAll('employees')));
    }

    public function tearDown(): void
    {
        $this->employee->destroy([
            'id' => $this->id
        ]);
    }

    public function testValidate()
    {
        // empty
        $this->faker->name = null;
        $this->faker->address = null;
        $noParams = $this->employee->validate($this->faker);
        $this->assertEquals(false, $noParams);

        // no address
        $this->faker->name = $this->name;
        $this->faker->address = null;
        $noAddress = $this->employee->validate($this->faker);
        $this->employee->errors($this->faker);
        $errors = $this->employee->getErrors();

        $this->assertEquals(false, $noAddress);
        $this->assertEquals("Address must be provided.", $errors[0]);

        // no name
        $this->faker->name = null;
        $this->faker->address = $this->address;
        $noName = $this->employee->validate($this->faker);
        $this->employee->errors($this->faker);
        $errors = $this->employee->getErrors();

        $this->assertEquals(false, $noName);
        $this->assertEquals("Name must be provided.", $errors[0]);

        // valid
        $this->faker->name = $this->name;
        $this->faker->address = $this->address;
        $valid = $this->employee->validate($this->faker);
        $this->assertEquals(true, $valid);
    }

    // save - insert
    public function testInsert()
    {
        $currentCount = (count(App::get('database')->selectAll('employees')));
        $method = 'insert';
        $data = [
            'name' => $this->faker->name,
            'address' => $this->faker->address
        ];
        $success = $this->employee->save($data, $method);
        $newCount = (count(App::get('database')->selectAll('employees')));

        $this->assertEquals($currentCount+= 1, $newCount); // 1 added
        $this->assertEquals(true, $success);
    }

    // save - update
    public function testUpdate()
    {
        $method = 'update';
        $data = [
            'name' => $this->name,
            'address' => $this->address,
            'id' => $this->id
        ];
        $success = $this->employee->save($data, $method);

        $this->assertEquals(true, $success);
    }

    public function testDestory()
    {
        $currentCount = (count(App::get('database')->selectAll('employees')));
        $data = [
            'id' => $this->id
        ];
        $success = $this->employee->destroy($data);
        $newCount = (count(App::get('database')->selectAll('employees')));

        $this->assertEquals($currentCount-= 1, $newCount); // 1 rmvd
        $this->assertEquals(true, $success);
    }
}
