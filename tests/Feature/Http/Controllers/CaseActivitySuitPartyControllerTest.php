<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CaseActivity;
use App\Models\CaseActivitySuitParty;
use App\Models\SuitParty;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CaseActivitySuitPartyController
 */
class CaseActivitySuitPartyControllerTest extends TestCase
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
        $caseActivitySuitParties = CaseActivitySuitParty::factory()->count(3)->create();

        $response = $this->get(route('case-activity-suit-party.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseActivitySuitPartyController::class,
            'store',
            \App\Http\Requests\CaseActivitySuitPartyStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $case_activity = CaseActivity::factory()->create();
        $suit_party = SuitParty::factory()->create();

        $response = $this->post(route('case-activity-suit-party.store'), [
            'case_activity_id' => $case_activity->id,
            'suit_party_id' => $suit_party->id,
        ]);

        $caseActivitySuitParties = CaseActivitySuitParty::query()
            ->where('case_activity_id', $case_activity->id)
            ->where('suit_party_id', $suit_party->id)
            ->get();
        $this->assertCount(1, $caseActivitySuitParties);
        $caseActivitySuitParty = $caseActivitySuitParties->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $caseActivitySuitParty = CaseActivitySuitParty::factory()->create();

        $response = $this->get(route('case-activity-suit-party.show', $caseActivitySuitParty));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseActivitySuitPartyController::class,
            'update',
            \App\Http\Requests\CaseActivitySuitPartyUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $caseActivitySuitParty = CaseActivitySuitParty::factory()->create();
        $case_activity = CaseActivity::factory()->create();
        $suit_party = SuitParty::factory()->create();

        $response = $this->put(route('case-activity-suit-party.update', $caseActivitySuitParty), [
            'case_activity_id' => $case_activity->id,
            'suit_party_id' => $suit_party->id,
        ]);

        $caseActivitySuitParty->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($case_activity->id, $caseActivitySuitParty->case_activity_id);
        $this->assertEquals($suit_party->id, $caseActivitySuitParty->suit_party_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $caseActivitySuitParty = CaseActivitySuitParty::factory()->create();

        $response = $this->delete(route('case-activity-suit-party.destroy', $caseActivitySuitParty));

        $response->assertNoContent();

        $this->assertSoftDeleted($caseActivitySuitParty);
    }
}
