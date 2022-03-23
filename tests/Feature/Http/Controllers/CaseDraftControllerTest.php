<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CaseDraft;
use App\Models\CaseRequest;
use App\Models\Hanler;
use App\Models\Solicitor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CaseDraftController
 */
class CaseDraftControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $caseDrafts = CaseDraft::factory()->count(3)->create();

        $response = $this->get(route('case-draft.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseDraftController::class,
            'store',
            \App\Http\Requests\CaseDraftStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $case_no = $this->faker->word;
        $title = $this->faker->sentence(4);
        $review_submitted = $this->faker->boolean;
        $hanler = Hanler::factory()->create();
        $solicitor = Solicitor::factory()->create();
        $case_request = CaseRequest::factory()->create();

        $response = $this->post(route('case-draft.store'), [
            'case_no' => $case_no,
            'title' => $title,
            'review_submitted' => $review_submitted,
            'handler_id' => $hanler->id,
            'solicitor_id' => $solicitor->id,
            'case_request_id' => $case_request->id,
        ]);

        $caseDrafts = CaseDraft::query()
            ->where('case_no', $case_no)
            ->where('title', $title)
            ->where('review_submitted', $review_submitted)
            ->where('handler_id', $hanler->id)
            ->where('solicitor_id', $solicitor->id)
            ->where('case_request_id', $case_request->id)
            ->get();
        $this->assertCount(1, $caseDrafts);
        $caseDraft = $caseDrafts->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $caseDraft = CaseDraft::factory()->create();

        $response = $this->get(route('case-draft.show', $caseDraft));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseDraftController::class,
            'update',
            \App\Http\Requests\CaseDraftUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $caseDraft = CaseDraft::factory()->create();
        $case_no = $this->faker->word;
        $title = $this->faker->sentence(4);
        $review_submitted = $this->faker->boolean;
        $hanler = Hanler::factory()->create();
        $solicitor = Solicitor::factory()->create();
        $case_request = CaseRequest::factory()->create();

        $response = $this->put(route('case-draft.update', $caseDraft), [
            'case_no' => $case_no,
            'title' => $title,
            'review_submitted' => $review_submitted,
            'handler_id' => $hanler->id,
            'solicitor_id' => $solicitor->id,
            'case_request_id' => $case_request->id,
        ]);

        $caseDraft->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($case_no, $caseDraft->case_no);
        $this->assertEquals($title, $caseDraft->title);
        $this->assertEquals($review_submitted, $caseDraft->review_submitted);
        $this->assertEquals($hanler->id, $caseDraft->handler_id);
        $this->assertEquals($solicitor->id, $caseDraft->solicitor_id);
        $this->assertEquals($case_request->id, $caseDraft->case_request_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $caseDraft = CaseDraft::factory()->create();

        $response = $this->delete(route('case-draft.destroy', $caseDraft));

        $response->assertNoContent();

        $this->assertSoftDeleted($caseDraft);
    }
}
