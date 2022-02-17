<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Solicitor;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SolicitorController
 */
class SolicitorControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @var \Illuminate\Foundation\Auth\User
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
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
        $solicitors = Solicitor::factory()->count(3)->create();

        $response = $this->get(route('solicitors.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SolicitorController::class,
            'store',
            \App\Http\Requests\SolicitorStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;
        $office_address = $this->faker->word;
        $contact_name = $this->faker->word;
        $contact_phone = $this->faker->word;
        $location = $this->faker->word;
        $state = State::inRandomOrder()->first();

        $response = $this->post(route('solicitors.store'), [
            'name' => $name,
            'office_address' => $office_address,
            'contact_name' => $contact_name,
            'contact_phone' => $contact_phone,
            'location' => $location,
            'state_id' => $state->id,
        ]);

        $solicitors = Solicitor::query()
            ->where('name', $name)
            ->where('office_address', $office_address)
            ->where('contact_name', $contact_name)
            ->where('contact_phone', $contact_phone)
            ->where('location', $location)
            ->where('state_id', $state->id)
            ->get();
        $this->assertCount(1, $solicitors);
        $solicitor = $solicitors->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $solicitor = Solicitor::factory()->create();

        $response = $this->get(route('solicitors.show', $solicitor));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SolicitorController::class,
            'update',
            \App\Http\Requests\SolicitorUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $solicitor = Solicitor::inRandomOrder()->first();
        $name = $this->faker->name;
        $office_address = $this->faker->word;
        $contact_name = $this->faker->word;
        $contact_phone = $this->faker->word;
        $location = $this->faker->word;
        $state = State::inRandomOrder()->first();

        $response = $this->put(route('solicitors.update', $solicitor), [
            'name' => $name,
            'office_address' => $office_address,
            'contact_name' => $contact_name,
            'contact_phone' => $contact_phone,
            'location' => $location,
            'state_id' => $state->id,
        ]);

        $solicitor->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $solicitor->name);
        $this->assertEquals($office_address, $solicitor->office_address);
        $this->assertEquals($contact_name, $solicitor->contact_name);
        $this->assertEquals($contact_phone, $solicitor->contact_phone);
        $this->assertEquals($location, $solicitor->location);
        $this->assertEquals($state->id, $solicitor->state_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $solicitor = Solicitor::factory()->create();

        $response = $this->delete(route('solicitors.destroy', $solicitor));

        $response->assertNoContent();

        $this->assertSoftDeleted($solicitor);
    }
}
