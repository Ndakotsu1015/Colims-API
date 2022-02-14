<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CaseRequest;
use App\Models\Initiator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CaseRequestController
 */
class CaseRequestControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $caseRequests = CaseRequest::factory()->count(3)->create();

        $response = $this->get(route('case-request.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseRequestController::class,
            'store',
            \App\Http\Requests\CaseRequestStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $title = $this->faker->sentence(4);
        $content = $this->faker->paragraphs(3, true);
        $request_origin = $this->faker->word;
        $initiator = Initiator::factory()->create();
        $status = $this->faker->word;

        $response = $this->post(route('case-request.store'), [
            'title' => $title,
            'content' => $content,
            'request_origin' => $request_origin,
            'initiator_id' => $initiator->id,
            'status' => $status,
        ]);

        $caseRequests = CaseRequest::query()
            ->where('title', $title)
            ->where('content', $content)
            ->where('request_origin', $request_origin)
            ->where('initiator_id', $initiator->id)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $caseRequests);
        $caseRequest = $caseRequests->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $caseRequest = CaseRequest::factory()->create();

        $response = $this->get(route('case-request.show', $caseRequest));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseRequestController::class,
            'update',
            \App\Http\Requests\CaseRequestUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $caseRequest = CaseRequest::factory()->create();
        $title = $this->faker->sentence(4);
        $content = $this->faker->paragraphs(3, true);
        $request_origin = $this->faker->word;
        $initiator = Initiator::factory()->create();
        $status = $this->faker->word;

        $response = $this->put(route('case-request.update', $caseRequest), [
            'title' => $title,
            'content' => $content,
            'request_origin' => $request_origin,
            'initiator_id' => $initiator->id,
            'status' => $status,
        ]);

        $caseRequest->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $caseRequest->title);
        $this->assertEquals($content, $caseRequest->content);
        $this->assertEquals($request_origin, $caseRequest->request_origin);
        $this->assertEquals($initiator->id, $caseRequest->initiator_id);
        $this->assertEquals($status, $caseRequest->status);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $caseRequest = CaseRequest::factory()->create();

        $response = $this->delete(route('case-request.destroy', $caseRequest));

        $response->assertNoContent();

        $this->assertSoftDeleted($caseRequest);
    }
}
