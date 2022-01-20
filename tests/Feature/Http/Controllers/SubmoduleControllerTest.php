<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Submodule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SubmoduleController
 */
class SubmoduleControllerTest extends TestCase
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
        $submodules = Submodule::factory()->count(3)->create();

        $response = $this->get(route('submodule.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SubmoduleController::class,
            'store',
            \App\Http\Requests\SubmoduleStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;
        $module_id = $this->faker->randomNumber();
        $is_active = $this->faker->boolean;

        $response = $this->post(route('submodule.store'), [
            'name' => $name,
            'module_id' => $module_id,
            'is_active' => $is_active,
        ]);

        $submodules = Submodule::query()
            ->where('name', $name)
            ->where('module_id', $module_id)
            ->where('is_active', $is_active)
            ->get();
        $this->assertCount(1, $submodules);
        $submodule = $submodules->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $submodule = Submodule::factory()->create();

        $response = $this->get(route('submodule.show', $submodule));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SubmoduleController::class,
            'update',
            \App\Http\Requests\SubmoduleUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $submodule = Submodule::factory()->create();
        $name = $this->faker->name;
        $module_id = $this->faker->randomNumber();
        $is_active = $this->faker->boolean;

        $response = $this->put(route('submodule.update', $submodule), [
            'name' => $name,
            'module_id' => $module_id,
            'is_active' => $is_active,
        ]);

        $submodule->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $submodule->name);
        $this->assertEquals($module_id, $submodule->module_id);
        $this->assertEquals($is_active, $submodule->is_active);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $submodule = Submodule::factory()->create();

        $response = $this->delete(route('submodule.destroy', $submodule));

        $response->assertNoContent();

        $this->assertSoftDeleted($submodule);
    }
}
