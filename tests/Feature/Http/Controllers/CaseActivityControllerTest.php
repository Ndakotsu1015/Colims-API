<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CaseActivity;
use App\Models\CaseOutcome;
use App\Models\CourtCase;
use App\Models\Solicitor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CaseActivityController
 */
class CaseActivityControllerTest extends TestCase
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
        $caseActivities = CaseActivity::factory()->count(3)->create();

        $response = $this->get(route('case-activity.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseActivityController::class,
            'store',
            \App\Http\Requests\CaseActivityStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $description = $this->faker->text;
        $court_case = CourtCase::factory()->create();
        $user = User::factory()->create();        
        $status = $this->faker->word;
        $location = $this->faker->word;
        $case_outcome = CaseOutcome::factory()->create();
        $solicitor = Solicitor::factory()->create();

        $response = $this->post(route('case-activity.store'), [
            'description' => $description,
            'court_case_id' => $court_case->id,
            'user_id' => $user->id,
            'status' => $status,
            'location' => $location,
            'case_outcome_id' => $case_outcome->id,   
            'solicitor_id' => $solicitor->id,         
        ]);

        $caseActivities = CaseActivity::query()
            ->where('description', $description)
            ->where('court_case_id', $court_case->id)
            ->where('user_id', $user->id)
            ->where('status', $status)
            ->where('location', $location)
            ->where('case_outcome_id', $case_outcome->id)
            ->where('solicitor_id', $solicitor->id)
            ->get();
        $this->assertCount(1, $caseActivities);
        $caseActivity = $caseActivities->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $caseActivity = CaseActivity::factory()->create();

        $response = $this->get(route('case-activity.show', $caseActivity));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseActivityController::class,
            'update',
            \App\Http\Requests\CaseActivityUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $caseActivity = CaseActivity::factory()->create();
        $description = $this->faker->text;
        $court_case = CourtCase::factory()->create();
        $user = User::factory()->create();
        $status = $this->faker->word;
        $location = $this->faker->word;
        $case_outcome = CaseOutcome::factory()->create();
        $solicitor = Solicitor::factory()->create();

        $response = $this->put(route('case-activity.update', $caseActivity), [
            'description' => $description,
            'court_case_id' => $court_case->id,
            'user_id' => $user->id,
            'status' => $status,
            'location' => $location,
            'case_outcome_id' => $case_outcome->id,
            'solicitor_id' => $solicitor->id,
        ]);

        $caseActivity->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($description, $caseActivity->description);
        $this->assertEquals($court_case->id, $caseActivity->court_case_id);
        $this->assertEquals($user->id, $caseActivity->user_id);
        $this->assertEquals($status, $caseActivity->status);
        $this->assertEquals($location, $caseActivity->location);
        $this->assertEquals($case_outcome->id, $caseActivity->case_outcome_id);
        $this->assertEquals($solicitor->id, $caseActivity->solicitor_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $caseActivity = CaseActivity::factory()->create();

        $response = $this->delete(route('case-activity.destroy', $caseActivity));

        $response->assertNoContent();

        $this->assertSoftDeleted($caseActivity);
    }
}
