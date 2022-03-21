<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\AwardLetter;
use App\Models\ContractDocumentSubmission;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContractDocumentSubmissionController
 */
class ContractDocumentSubmissionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $ContractDocumentSubmissions = ContractDocumentSubmission::factory()->count(3)->create();

        $response = $this->get(route('award-letter-contract-document-submission.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractDocumentSubmissionController::class,
            'store',
            \App\Http\Requests\ContractDocumentSubmissionStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $is_submitted = $this->faker->boolean;
        $is_approved = $this->faker->boolean;
        $due_date = $this->faker->date();
        $award_letter = AwardLetter::factory()->create();

        $response = $this->post(route('award-letter-contract-document-submission.store'), [
            'is_submitted' => $is_submitted,
            'is_approved' => $is_approved,
            'due_date' => $due_date,
            'award_letter_id' => $award_letter->id,
        ]);

        $ContractDocumentSubmissions = ContractDocumentSubmission::query()
            ->where('is_submitted', $is_submitted)
            ->where('is_approved', $is_approved)
            ->where('due_date', $due_date)
            ->where('award_letter_id', $award_letter->id)
            ->get();
        $this->assertCount(1, $ContractDocumentSubmissions);
        $ContractDocumentSubmission = $ContractDocumentSubmissions->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $ContractDocumentSubmission = ContractDocumentSubmission::factory()->create();

        $response = $this->get(route('award-letter-contract-document-submission.show', $ContractDocumentSubmission));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractDocumentSubmissionController::class,
            'update',
            \App\Http\Requests\ContractDocumentSubmissionUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $ContractDocumentSubmission = ContractDocumentSubmission::factory()->create();
        $is_submitted = $this->faker->boolean;
        $is_approved = $this->faker->boolean;
        $due_date = $this->faker->date();
        $award_letter = AwardLetter::factory()->create();

        $response = $this->put(route('award-letter-contract-document-submission.update', $ContractDocumentSubmission), [
            'is_submitted' => $is_submitted,
            'is_approved' => $is_approved,
            'due_date' => $due_date,
            'award_letter_id' => $award_letter->id,
        ]);

        $ContractDocumentSubmission->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($is_submitted, $ContractDocumentSubmission->is_submitted);
        $this->assertEquals($is_approved, $ContractDocumentSubmission->is_approved);
        $this->assertEquals(Carbon::parse($due_date), $ContractDocumentSubmission->due_date);
        $this->assertEquals($award_letter->id, $ContractDocumentSubmission->award_letter_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $ContractDocumentSubmission = ContractDocumentSubmission::factory()->create();

        $response = $this->delete(route('award-letter-contract-document-submission.destroy', $ContractDocumentSubmission));

        $response->assertNoContent();

        $this->assertSoftDeleted($ContractDocumentSubmission);
    }
}
