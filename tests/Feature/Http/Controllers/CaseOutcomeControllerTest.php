<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CaseOutcome;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CaseOutcomeController
 */
class CaseOutcomeControllerTest extends TestCase
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
        $caseOutcomes = CaseOutcome::factory()->count(3)->create();

        $response = $this->get(route('case-outcome.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseOutcomeController::class,
            'store',
            \App\Http\Requests\CaseOutcomeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;

        $response = $this->post(route('case-outcome.store'), [
            'name' => $name,
        ]);

        $caseOutcomes = CaseOutcome::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $caseOutcomes);
        $caseOutcome = $caseOutcomes->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $caseOutcome = CaseOutcome::inRandomOrder()->first();

        $response = $this->get(route('case-outcome.show', $caseOutcome));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseOutcomeController::class,
            'update',
            \App\Http\Requests\CaseOutcomeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $caseOutcome = CaseOutcome::inRandomOrder()->first();
        $name = $this->faker->name;

        $response = $this->put(route('case-outcome.update', $caseOutcome), [
            'name' => $name,
        ]);

        $caseOutcome->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $caseOutcome->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $caseOutcome = CaseOutcome::factory()->create();

        $response = $this->delete(route('case-outcome.destroy', $caseOutcome));

        $response->assertNoContent();

        $this->assertSoftDeleted($caseOutcome);
    }
}
