<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Duration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DurationController
 */
class DurationControllerTest extends TestCase
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
        $durations = Duration::factory()->count(3)->create();

        $response = $this->get(route('duration.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DurationController::class,
            'store',
            \App\Http\Requests\DurationStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;
        $number_of_days = $this->faker->randomNumber();

        $response = $this->post(route('duration.store'), [
            'name' => $name,
            'number_of_days' => $number_of_days,
        ]);

        $durations = Duration::query()
            ->where('name', $name)
            ->where('number_of_days', $number_of_days)
            ->get();
        $this->assertCount(1, $durations);
        $duration = $durations->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $duration = Duration::factory()->create();

        $response = $this->get(route('duration.show', $duration));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DurationController::class,
            'update',
            \App\Http\Requests\DurationUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $duration = Duration::factory()->create();
        $name = $this->faker->name;
        $number_of_days = $this->faker->randomNumber();

        $response = $this->put(route('duration.update', $duration), [
            'name' => $name,
            'number_of_days' => $number_of_days,
        ]);

        $duration->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $duration->name);
        $this->assertEquals($number_of_days, $duration->number_of_days);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $duration = Duration::factory()->create();

        $response = $this->delete(route('duration.destroy', $duration));

        $response->assertNoContent();

        $this->assertDeleted($duration);
    }
}
