<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\PrivilegeClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PrivilegeClassController
 */
class PrivilegeClassControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // $this->seed();
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
        $privilegeClasses = PrivilegeClass::factory()->count(3)->create();

        $response = $this->get(route('privilege-classes.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PrivilegeClassController::class,
            'store',
            \App\Http\Requests\PrivilegeClassStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;

        $response = $this->post(route('privilege-classes.store'), [
            'name' => $name,
        ]);

        $privilegeClasses = PrivilegeClass::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $privilegeClasses);
        $privilegeClass = $privilegeClasses->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $privilegeClass = PrivilegeClass::factory()->create();

        $response = $this->get(route('privilege-classes.show', $privilegeClass));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PrivilegeClassController::class,
            'update',
            \App\Http\Requests\PrivilegeClassUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $privilegeClass = PrivilegeClass::factory()->create();
        $name = $this->faker->name;

        $response = $this->put(route('privilege-classes.update', $privilegeClass), [
            'name' => $name,
        ]);

        $privilegeClass->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $privilegeClass->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $privilegeClass = PrivilegeClass::factory()->create();

        $response = $this->delete(route('privilege-classes.destroy', $privilegeClass));

        $response->assertNoContent();

        $this->assertSoftDeleted($privilegeClass);
    }
}
