<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Mockery;
use Faker;
use App\Employee;

use App\Core\App;


class EmployeeTest extends TestCase
{
    public $faker;
    public $employee;
    /** EmployeeRepositoryInterface|MockInterface $employeeRepo */
    public $employeeRepo;
    public $name = 'Tester Test';
    public $address = 'Test Street';

    public function setUp(): void
    {
        // db connection
        App::bind('config', require '../config.php');
        $this->employeeRepo = Mockery::mock('App\Interfaces\EmployeeRepositoryInterface');

        // fixture object
        $this->faker = Faker\Factory::create();
        $this->faker->name = $this->name;
        $this->faker->address = $this->address;
    }

    public function testFind()
    {
        $this->employeeRepo->shouldReceive('find')->with(2)->once()->andReturn(true);
        $this->employee = new Employee($this->employeeRepo);
        $result = $this->employee->find(2);
        $this->assertEquals(true, $result);
    }

    public function testCreate()
    {
        $data = [
            'name' => $this->faker->name,
            'address' => $this->faker->address
        ];
        $this->employeeRepo->shouldReceive('create')->with($data)->once()->andReturn(true);
        $this->employee = new Employee($this->employeeRepo);
        $result = $this->employee->create(
            json_decode(
                json_encode(
                    $data
                )
            )
        );
        $this->assertEquals(true, $result);
    }

    public function testUpdate()
    {
        $data =  [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'id' => 2
        ];
        $this->employeeRepo->shouldReceive('update')->with($data)->once()->andReturn(true);
        $this->employee = new Employee($this->employeeRepo);
        $result = $this->employee->update(
            json_decode(
                json_encode(
                    $data
                )
            )
        );
        $this->assertEquals(true, $result);
    }

    public function testDelete()
    {
        $data = [
            'id' => $this->id
        ];
        $this->employeeRepo->shouldReceive('delete')->with($data)->once()->andReturn(true);
        $this->employee = new Employee($this->employeeRepo);
        $result = $this->employee->delete(
            json_decode(
                json_encode(
                    $data
                )
            )
        );
        $this->assertEquals(true, $result);
    }

    public function testValidate()
    {
        $this->employee = new Employee($this->employeeRepo);
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
}
