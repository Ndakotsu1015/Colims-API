<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Privilege;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PrivilegeController
 */
class PrivilegeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @var \Illuminate\Foundation\Auth\User
     */
    private $user;

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
        $privileges = Privilege::factory()->count(3)->create();

        $response = $this->get(route('privileges.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PrivilegeController::class,
            'store',
            \App\Http\Requests\PrivilegeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;

        $response = $this->post(route('privileges.store'), [
            'name' => $name,
        ]);

        $privileges = Privilege::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $privileges);
        $privilege = $privileges->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $privilege = Privilege::factory()->create();

        $response = $this->get(route('privileges.show', $privilege));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PrivilegeController::class,
            'update',
            \App\Http\Requests\PrivilegeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $privilege = Privilege::factory()->create();
        $name = $this->faker->name;

        $response = $this->put(route('privileges.update', $privilege), [
            'name' => $name,
        ]);

        $privilege->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $privilege->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $privilege = Privilege::factory()->create();

        $response = $this->delete(route('privileges.destroy', $privilege));

        $response->assertNoContent();

        $this->assertSoftDeleted($privilege);
    }
}
