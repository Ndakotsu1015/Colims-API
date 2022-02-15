<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CaseParticipant;
use App\Models\CourtCase;
use App\Models\SuitParty;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SuitPartyController
 */
class SuitPartyControllerTest extends TestCase
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
        $suitParties = SuitParty::factory()->count(3)->create();

        $response = $this->get(route('suit-parties.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SuitPartyController::class,
            'store',
            \App\Http\Requests\SuitPartyStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {        
        $court_case = CourtCase::inRandomOrder()->first();
        $case_participant = CaseParticipant::inRandomOrder()->first();
        $type = $this->faker->word;

        $response = $this->post(route('suit-parties.store'), [            
            'court_case_id' => $court_case->id,
            'case_participant_id' => $case_participant->id,
            'type' => $type,
        ]);

        $suitParties = SuitParty::query()           
            ->where('court_case_id', $court_case->id)
            ->where('case_participant_id', $case_participant->id)
            ->where('type', $type)
            ->get();
        $this->assertCount(1, $suitParties);
        $suitParty = $suitParties->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $suitParty = SuitParty::factory()->create();

        $response = $this->get(route('suit-parties.show', $suitParty));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SuitPartyController::class,
            'update',
            \App\Http\Requests\SuitPartyUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $suitParty = SuitParty::inRandomOrder()->first();
        
        $court_case = CourtCase::inRandomOrder()->first();
        $case_participant = CaseParticipant::inRandomOrder()->first();
        $type = $this->faker->word;

        $response = $this->put(route('suit-parties.update', $suitParty), [            
            'court_case_id' => $court_case->id,
            'case_participant_id' => $case_participant->id,
            'type' => $type,
        ]);

        $suitParty->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);
       
        $this->assertEquals($court_case->id, $suitParty->court_case_id);
        $this->assertEquals($type, $suitParty->type);
        $this->assertEquals($case_participant->id, $suitParty->case_participant_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $suitParty = SuitParty::factory()->create();

        $response = $this->delete(route('suit-parties.destroy', $suitParty));

        $response->assertNoContent();

        $this->assertSoftDeleted($suitParty);
    }
}
