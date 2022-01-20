<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\StateController
 */
class StateControllerTest extends TestCase
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
        $states = State::factory()->count(3)->create();

        $response = $this->get(route('state.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StateController::class,
            'store',
            \App\Http\Requests\StateStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;
        $state_code = $this->faker->word;
        $is_active = $this->faker->boolean;

        $response = $this->post(route('state.store'), [
            'name' => $name,
            'state_code' => $state_code,
            'is_active' => $is_active,
        ]);

        $states = State::query()
            ->where('name', $name)
            ->where('state_code', $state_code)
            ->where('is_active', $is_active)
            ->get();
        $this->assertCount(1, $states);
        $state = $states->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $state = State::factory()->create();

        $response = $this->get(route('state.show', $state));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StateController::class,
            'update',
            \App\Http\Requests\StateUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $state = State::factory()->create();
        $name = $this->faker->name;
        $state_code = $this->faker->word;
        $is_active = $this->faker->boolean;

        $response = $this->put(route('state.update', $state), [
            'name' => $name,
            'state_code' => $state_code,
            'is_active' => $is_active,
        ]);

        $state->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $state->name);
        $this->assertEquals($state_code, $state->state_code);
        $this->assertEquals($is_active, $state->is_active);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $state = State::factory()->create();

        $response = $this->delete(route('state.destroy', $state));

        $response->assertNoContent();

        $this->assertSoftDeleted($state);
    }
}
