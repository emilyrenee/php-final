<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Mockery;
use Faker;
use App\Employee;
use App\Repositories\EmployeeRepository;

use App\Core\App;
use App\Core\{QueryBuilder, Connection};


class EmployeeTest extends TestCase
{
    public $faker;
    public $employee;
    /** EmployeeRepositoryInterface|MockInterface $employeeRepo */
    public $employeeRepo;
    public $name = 'Tester Test';
    public $address = 'Test Street';
    public $id;

    public function setUp(): void
    {
        // db connection
        App::bind('config', require '../config.php');
        // for actual inserts, not mocks
        App::bind('database', new QueryBuilder(
            Connection::makeConnection(App::get('config')['database'])
        ));
        // for mocks
        $this->employeeRepo = Mockery::mock('App\Interfaces\EmployeeRepositoryInterface');

        // fixture object
        $this->faker = Faker\Factory::create();
        $this->faker->name = $this->name;
        $this->faker->address = $this->address;
    }

    public function testModelValidate()
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

    public function testModelSaveInsert()
    {
        $currentCount = (count(App::get('database')->selectAll('employees')));
        $data = [
            'name' => $this->faker->name,
            'address' => $this->faker->address
        ];
        $this->employee = new Employee(
            new EmployeeRepository(App::get('database'))
        );
        $success = $this->employee->save(
            json_decode(
                json_encode(
                    $data
                )
            ),
            'insert'
        );
        $newCount = (count(App::get('database')->selectAll('employees')));
        $this->assertEquals($currentCount += 1, $newCount); // 1 added
        $this->assertEquals(true, $success);
    }

    public function testModelSaveUpdate()
    {
        $employees = App::get('database')->selectAll('employees');
        $currentCount = (count($employees));
        $data = [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'id' => $employees[0]->id,
        ];
        $this->employee = new Employee(
            new EmployeeRepository(App::get('database'))
        );
        $success = $this->employee->save(
            json_decode(
                json_encode(
                    $data
                )
            ),
            'update'
        );
        $newCount = (count(App::get('database')->selectAll('employees')));
        $this->assertEquals($currentCount, $newCount); // none added
        $this->assertEquals(true, $success);
    }

    public function testModelDestory()
    {
        $employees = App::get('database')->selectAll('employees');
        $currentCount = (count($employees));
        $data = [
            'id' => $employees[0]->id
        ];
        $this->employee = new Employee(
            new EmployeeRepository(App::get('database'))
        );
        $success = $this->employee->destroy($data);
        $newCount = (count(App::get('database')->selectAll('employees')));
        $this->assertEquals($currentCount -= 1, $newCount); // 1 rmvd
        $this->assertEquals(true, $success);
    }

    public function testModelFind()
    {
        $this->employeeRepo->shouldReceive('find')->with(2)->once()->andReturn(true);
        $this->employee = new Employee($this->employeeRepo);
        $result = $this->employee->find(2);
        $this->assertEquals(true, $result);
    }

    public function testCreateMock()
    {
        $data = [
            'name' => $this->faker->name,
            'address' => $this->faker->address
        ];
        $this->employeeRepo->shouldReceive('create')->once()->andReturn(true);
        $this->employee = new Employee($this->employeeRepo);
        $result = $this->employee->create(
            json_decode(
                json_encode(
                    $data
                )
            ),
            'insert'
        );
        $this->assertEquals(true, $result);
    }

    public function testUpdateMock()
    {
        $data =  [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'id' => 2
        ];
        $this->employeeRepo->shouldReceive('update')->once()->andReturn(true);
        $this->employee = new Employee($this->employeeRepo);
        $result = $this->employee->update(
            json_decode(
                json_encode(
                    $data
                )
            ),
            'update'
        );
        $this->assertEquals(true, $result);
    }

    public function testDeleteMock()
    {
        $data = [
            'id' => $this->id
        ];
        $this->employeeRepo->shouldReceive('destroy')->with($data)->once()->andReturn(true);
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
}
