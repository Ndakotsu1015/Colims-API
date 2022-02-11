<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CaseRequest;
use App\Models\CaseRequestMovement;
use App\Models\ForwardTo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CaseRequestMovementController
 */
class CaseRequestMovementControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $caseRequestMovements = CaseRequestMovement::factory()->count(3)->create();

        $response = $this->get(route('case-request-movement.index'));

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
        $case_request = CaseRequest::factory()->create();
        $user = User::factory()->create();
        $forward_to = ForwardTo::factory()->create();
        $notes = $this->faker->text;

        $response = $this->post(route('case-request-movement.store'), [
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

        $response = $this->get(route('case-request-movement.show', $caseRequestMovement));

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
        $caseRequestMovement = CaseRequestMovement::factory()->create();
        $case_request = CaseRequest::factory()->create();
        $user = User::factory()->create();
        $forward_to = ForwardTo::factory()->create();
        $notes = $this->faker->text;

        $response = $this->put(route('case-request-movement.update', $caseRequestMovement), [
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

        $response = $this->delete(route('case-request-movement.destroy', $caseRequestMovement));

        $response->assertNoContent();

        $this->assertSoftDeleted($caseRequestMovement);
    }
}
