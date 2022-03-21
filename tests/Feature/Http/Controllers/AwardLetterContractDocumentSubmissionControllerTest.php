<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\AwardLetter;
use App\Models\AwardLetterContractDocumentSubmission;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AwardLetterContractDocumentSubmissionController
 */
class AwardLetterContractDocumentSubmissionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $awardLetterContractDocumentSubmissions = AwardLetterContractDocumentSubmission::factory()->count(3)->create();

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
            \App\Http\Controllers\AwardLetterContractDocumentSubmissionController::class,
            'store',
            \App\Http\Requests\AwardLetterContractDocumentSubmissionStoreRequest::class
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

        $awardLetterContractDocumentSubmissions = AwardLetterContractDocumentSubmission::query()
            ->where('is_submitted', $is_submitted)
            ->where('is_approved', $is_approved)
            ->where('due_date', $due_date)
            ->where('award_letter_id', $award_letter->id)
            ->get();
        $this->assertCount(1, $awardLetterContractDocumentSubmissions);
        $awardLetterContractDocumentSubmission = $awardLetterContractDocumentSubmissions->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $awardLetterContractDocumentSubmission = AwardLetterContractDocumentSubmission::factory()->create();

        $response = $this->get(route('award-letter-contract-document-submission.show', $awardLetterContractDocumentSubmission));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AwardLetterContractDocumentSubmissionController::class,
            'update',
            \App\Http\Requests\AwardLetterContractDocumentSubmissionUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $awardLetterContractDocumentSubmission = AwardLetterContractDocumentSubmission::factory()->create();
        $is_submitted = $this->faker->boolean;
        $is_approved = $this->faker->boolean;
        $due_date = $this->faker->date();
        $award_letter = AwardLetter::factory()->create();

        $response = $this->put(route('award-letter-contract-document-submission.update', $awardLetterContractDocumentSubmission), [
            'is_submitted' => $is_submitted,
            'is_approved' => $is_approved,
            'due_date' => $due_date,
            'award_letter_id' => $award_letter->id,
        ]);

        $awardLetterContractDocumentSubmission->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($is_submitted, $awardLetterContractDocumentSubmission->is_submitted);
        $this->assertEquals($is_approved, $awardLetterContractDocumentSubmission->is_approved);
        $this->assertEquals(Carbon::parse($due_date), $awardLetterContractDocumentSubmission->due_date);
        $this->assertEquals($award_letter->id, $awardLetterContractDocumentSubmission->award_letter_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $awardLetterContractDocumentSubmission = AwardLetterContractDocumentSubmission::factory()->create();

        $response = $this->delete(route('award-letter-contract-document-submission.destroy', $awardLetterContractDocumentSubmission));

        $response->assertNoContent();

        $this->assertSoftDeleted($awardLetterContractDocumentSubmission);
    }
}
