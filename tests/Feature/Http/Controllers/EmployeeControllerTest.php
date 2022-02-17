<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Database\Seeders\EmployeeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EmployeeController
 */
class EmployeeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @var \Illuminate\Foundation\Auth\User
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([EmployeeSeeder::class]);
        $this->withHeader('X-Requested-With', 'XMLHttpRequest');
        $this->withHeader('Accept', 'application/json');

        
        User::withoutEvents(function () {
            $this->user = User::factory()->create([
                'name' => 'abdul',
                'email' => $this->faker->unique()->safeEmail,
                'password' => bcrypt("123456"),
            ]);
        });

        Sanctum::actingAs($this->user);
    }

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $employees = Employee::factory()->count(3)->create();

        $response = $this->get(route('employees.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployeeController::class,
            'store',
            \App\Http\Requests\EmployeeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $full_name = $this->faker->word;
        $title = $this->faker->sentence(4);
        $designation = $this->faker->word;
        $signature_file = $this->faker->word;

        $response = $this->post(route('employees.store'), [
            'full_name' => $full_name,
            'title' => $title,
            'designation' => $designation,
            'signature_file' => $signature_file,
        ]);

        $employees = Employee::query()
            ->where('full_name', $full_name)
            ->where('title', $title)
            ->where('designation', $designation)
            ->where('signature_file', $signature_file)
            ->get();
        $this->assertCount(1, $employees);
        $employee = $employees->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $employee = Employee::factory()->create();

        $response = $this->get(route('employees.show', $employee));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployeeController::class,
            'update',
            \App\Http\Requests\EmployeeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $employee = Employee::factory()->create();
        $full_name = $this->faker->word;
        $title = $this->faker->sentence(4);
        $designation = $this->faker->word;
        $signature_file = $this->faker->word;

        $response = $this->put(route('employees.update', $employee), [
            'full_name' => $full_name,
            'title' => $title,
            'designation' => $designation,
            'signature_file' => $signature_file,
        ]);

        $employee->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($full_name, $employee->full_name);
        $this->assertEquals($title, $employee->title);
        $this->assertEquals($designation, $employee->designation);
        $this->assertEquals($signature_file, $employee->signature_file);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $employee = Employee::factory()->create();

        $response = $this->delete(route('employees.destroy', $employee));

        $response->assertNoContent();

        $this->assertDeleted($employee);
    }
}
