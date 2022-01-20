<?php

namespace Tests\Feature\Http\Controllers;

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
        $suitParties = SuitParty::factory()->count(3)->create();

        $response = $this->get(route('suit-party.index'));

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
        $fullname = $this->faker->word;
        $phone_no = $this->faker->word;
        $residential_address = $this->faker->text;
        $court_case = CourtCase::factory()->create();
        $type = $this->faker->word;

        $response = $this->post(route('suit-party.store'), [
            'fullname' => $fullname,
            'phone_no' => $phone_no,
            'residential_address' => $residential_address,
            'court_case_id' => $court_case->id,
            'type' => $type,
        ]);

        $suitParties = SuitParty::query()
            ->where('fullname', $fullname)
            ->where('phone_no', $phone_no)
            ->where('residential_address', $residential_address)
            ->where('court_case_id', $court_case->id)
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

        $response = $this->get(route('suit-party.show', $suitParty));

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
        $suitParty = SuitParty::factory()->create();
        $fullname = $this->faker->word;
        $phone_no = $this->faker->word;
        $residential_address = $this->faker->text;
        $court_case = CourtCase::factory()->create();
        $type = $this->faker->word;

        $response = $this->put(route('suit-party.update', $suitParty), [
            'fullname' => $fullname,
            'phone_no' => $phone_no,
            'residential_address' => $residential_address,
            'court_case_id' => $court_case->id,
            'type' => $type,
        ]);

        $suitParty->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($fullname, $suitParty->fullname);
        $this->assertEquals($phone_no, $suitParty->phone_no);
        $this->assertEquals($residential_address, $suitParty->residential_address);
        $this->assertEquals($court_case->id, $suitParty->court_case_id);
        $this->assertEquals($type, $suitParty->type);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $suitParty = SuitParty::factory()->create();

        $response = $this->delete(route('suit-party.destroy', $suitParty));

        $response->assertNoContent();

        $this->assertSoftDeleted($suitParty);
    }
}
