<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CaseRequest;
use App\Models\Initiator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CaseRequestController
 */
class CaseRequestControllerTest extends TestCase
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
        $caseRequests = CaseRequest::factory()->count(3)->create();

        $response = $this->get(route('case-requests.index'));

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
        $initiator = User::inRandomOrder()->first();
        $caseReviewer = User::inRandomOrder()->first();
        $status = $this->faker->word;
        $recomendation_note = $this->faker->paragraphs(3, true);
        $should_go_to_trial = $this->faker->boolean;
        $is_case_closed = $this->faker->boolean;
        $recommendation_note_file = 'https://picsum.photos/seed/signature/200/200';

        $response = $this->post(route('case-requests.store'), [
            'title' => $title,
            'content' => $content,
            'initiator_id' => $initiator->id,
            'case_reviewer_id' => $caseReviewer->id,
            'status' => $status,
            'recomendation_note' => $recomendation_note,
            'should_go_to_trial' => $should_go_to_trial,
            'is_case_closed' => $is_case_closed,
            'recommendation_note_file' => $recommendation_note_file,
        ]);

        $caseRequests = CaseRequest::query()
            ->where('title', $title)
            ->where('content', $content)
            ->where('initiator_id', $initiator->id)
            ->where('case_reviewer_id', $caseReviewer->id)
            ->where('status', $status)
            ->where('recomendation_note', $recomendation_note)
            ->where('should_go_to_trial', $should_go_to_trial)
            ->where('is_case_closed', $is_case_closed)
            ->where('recommendation_note_file', $recommendation_note_file)
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

        $response = $this->get(route('case-requests.show', $caseRequest));

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
        $caseRequest = CaseRequest::inRandomOrder()->first();
        $title = $this->faker->sentence(4);
        $content = $this->faker->paragraphs(3, true);
        $initiator = User::inRandomOrder()->first();
        $caseReviewer = User::inRandomOrder()->first();
        $status = $this->faker->word;
        $recomendation_note = $this->faker->paragraphs(3, true);
        $should_go_to_trial = $this->faker->boolean;
        $is_case_closed = $this->faker->boolean;
        $recommendation_note_file = 'https://picsum.photos/seed/signature/200/200';

        $response = $this->put(route('case-requests.update', $caseRequest), [
            'title' => $title,
            'content' => $content,
            'initiator_id' => $initiator->id,
            'case_reviewer_id' => $caseReviewer->id,
            'status' => $status,
            'recomendation_note' => $recomendation_note,
            'should_go_to_trial' => $should_go_to_trial,
            'is_case_closed' => $is_case_closed,
            'recommendation_note_file' => $recommendation_note_file,
        ]);

        $caseRequest->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $caseRequest->title);
        $this->assertEquals($content, $caseRequest->content);
        $this->assertEquals($initiator->id, $caseRequest->initiator_id);
        $this->assertEquals($caseReviewer->id, $caseRequest->case_reviewer_id);
        $this->assertEquals($status, $caseRequest->status);
        $this->assertEquals($recomendation_note, $caseRequest->recomendation_note);
        $this->assertEquals($should_go_to_trial, $caseRequest->should_go_to_trial);
        $this->assertEquals($is_case_closed, $caseRequest->is_case_closed);
        $this->assertEquals($recommendation_note_file, $caseRequest->recommendation_note_file);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $caseRequest = CaseRequest::factory()->create();

        $response = $this->delete(route('case-requests.destroy', $caseRequest));

        $response->assertNoContent();

        $this->assertSoftDeleted($caseRequest);
    }
}
