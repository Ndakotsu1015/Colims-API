<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ContractCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContractCategoryController
 */
class ContractCategoryControllerTest extends TestCase
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
        $contractCategories = ContractCategory::factory()->count(3)->create();

        $response = $this->get(route('contract-categories.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractCategoryController::class,
            'store',
            \App\Http\Requests\ContractCategoryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;

        $response = $this->post(route('contract-categories.store'), [
            'name' => $name,
        ]);

        $contractCategories = ContractCategory::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $contractCategories);
        $contractCategory = $contractCategories->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $contractCategory = ContractCategory::factory()->create();

        $response = $this->get(route('contract-categories.show', $contractCategory));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractCategoryController::class,
            'update',
            \App\Http\Requests\ContractCategoryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $contractCategory = ContractCategory::factory()->create();
        $name = $this->faker->name;

        $response = $this->put(route('contract-categories.update', $contractCategory), [
            'name' => $name,
        ]);

        $contractCategory->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $contractCategory->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $contractCategory = ContractCategory::factory()->create();

        $response = $this->delete(route('contract-categories.destroy', $contractCategory));

        $response->assertNoContent();

        $this->assertDeleted($contractCategory);
    }
}
