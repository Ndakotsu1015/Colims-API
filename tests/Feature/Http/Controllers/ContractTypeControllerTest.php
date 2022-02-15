<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ContractType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContractTypeController
 */
class ContractTypeControllerTest extends TestCase
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
        $contractTypes = ContractType::factory()->count(3)->create();

        $response = $this->get(route('contract-types.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractTypeController::class,
            'store',
            \App\Http\Requests\ContractTypeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;

        $response = $this->post(route('contract-types.store'), [
            'name' => $name,
        ]);

        $contractTypes = ContractType::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $contractTypes);
        $contractType = $contractTypes->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $contractType = ContractType::factory()->create();

        $response = $this->get(route('contract-types.show', $contractType));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractTypeController::class,
            'update',
            \App\Http\Requests\ContractTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $contractType = ContractType::factory()->create();
        $name = $this->faker->name;

        $response = $this->put(route('contract-types.update', $contractType), [
            'name' => $name,
        ]);

        $contractType->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $contractType->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $contractType = ContractType::factory()->create();

        $response = $this->delete(route('contract-types.destroy', $contractType));

        $response->assertNoContent();

        $this->assertDeleted($contractType);
    }
}
