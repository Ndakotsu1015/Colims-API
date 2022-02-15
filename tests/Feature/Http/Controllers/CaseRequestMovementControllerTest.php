<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CaseRequest;
use App\Models\CaseRequestMovement;
use App\Models\ForwardTo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CaseRequestMovementController
 */
class CaseRequestMovementControllerTest extends TestCase
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
        $caseRequestMovements = CaseRequestMovement::factory()->count(3)->create();

        $response = $this->get(route('case-request-movements.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseRequestMovementController::class,
            'store',
            \App\Http\Requests\CaseRequestMovementStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $case_request = CaseRequest::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $forward_to = User::inRandomOrder()->first();
        $notes = $this->faker->text;

        $response = $this->post(route('case-request-movements.store'), [
            'case_request_id' => $case_request->id,
            'user_id' => $user->id,
            'forward_to' => $forward_to->id,
            'notes' => $notes,
        ]);

        $caseRequestMovements = CaseRequestMovement::query()
            ->where('case_request_id', $case_request->id)
            ->where('user_id', $user->id)
            ->where('forward_to', $forward_to->id)
            ->where('notes', $notes)
            ->get();
        $this->assertCount(1, $caseRequestMovements);
        $caseRequestMovement = $caseRequestMovements->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $caseRequestMovement = CaseRequestMovement::factory()->create();

        $response = $this->get(route('case-request-movements.show', $caseRequestMovement));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseRequestMovementController::class,
            'update',
            \App\Http\Requests\CaseRequestMovementUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $caseRequestMovement = CaseRequestMovement::inRandomOrder()->first();
        $case_request = CaseRequest::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $forward_to = User::inRandomOrder()->first();
        $notes = $this->faker->text;

        $response = $this->put(route('case-request-movements.update', $caseRequestMovement), [
            'case_request_id' => $case_request->id,
            'user_id' => $user->id,
            'forward_to' => $forward_to->id,
            'notes' => $notes,
        ]);

        $caseRequestMovement->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($case_request->id, $caseRequestMovement->case_request_id);
        $this->assertEquals($user->id, $caseRequestMovement->user_id);
        $this->assertEquals($forward_to->id, $caseRequestMovement->forward_to);
        $this->assertEquals($notes, $caseRequestMovement->notes);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $caseRequestMovement = CaseRequestMovement::factory()->create();

        $response = $this->delete(route('case-request-movements.destroy', $caseRequestMovement));

        $response->assertNoContent();

        $this->assertSoftDeleted($caseRequestMovement);
    }
}
