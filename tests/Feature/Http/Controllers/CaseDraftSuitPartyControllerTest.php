<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CaseDraft;
use App\Models\CaseDraftSuitParty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CaseDraftSuitPartyController
 */
class CaseDraftSuitPartyControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $caseDraftSuitParties = CaseDraftSuitParty::factory()->count(3)->create();

        $response = $this->get(route('case-draft-suit-party.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseDraftSuitPartyController::class,
            'store',
            \App\Http\Requests\CaseDraftSuitPartyStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;
        $phone_no = $this->faker->word;
        $address = $this->faker->word;
        $email = $this->faker->safeEmail;
        $type = $this->faker->word;
        $case_draft = CaseDraft::factory()->create();

        $response = $this->post(route('case-draft-suit-party.store'), [
            'name' => $name,
            'phone_no' => $phone_no,
            'address' => $address,
            'email' => $email,
            'type' => $type,
            'case_draft_id' => $case_draft->id,
        ]);

        $caseDraftSuitParties = CaseDraftSuitParty::query()
            ->where('name', $name)
            ->where('phone_no', $phone_no)
            ->where('address', $address)
            ->where('email', $email)
            ->where('type', $type)
            ->where('case_draft_id', $case_draft->id)
            ->get();
        $this->assertCount(1, $caseDraftSuitParties);
        $caseDraftSuitParty = $caseDraftSuitParties->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $caseDraftSuitParty = CaseDraftSuitParty::factory()->create();

        $response = $this->get(route('case-draft-suit-party.show', $caseDraftSuitParty));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseDraftSuitPartyController::class,
            'update',
            \App\Http\Requests\CaseDraftSuitPartyUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $caseDraftSuitParty = CaseDraftSuitParty::factory()->create();
        $name = $this->faker->name;
        $phone_no = $this->faker->word;
        $address = $this->faker->word;
        $email = $this->faker->safeEmail;
        $type = $this->faker->word;
        $case_draft = CaseDraft::factory()->create();

        $response = $this->put(route('case-draft-suit-party.update', $caseDraftSuitParty), [
            'name' => $name,
            'phone_no' => $phone_no,
            'address' => $address,
            'email' => $email,
            'type' => $type,
            'case_draft_id' => $case_draft->id,
        ]);

        $caseDraftSuitParty->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $caseDraftSuitParty->name);
        $this->assertEquals($phone_no, $caseDraftSuitParty->phone_no);
        $this->assertEquals($address, $caseDraftSuitParty->address);
        $this->assertEquals($email, $caseDraftSuitParty->email);
        $this->assertEquals($type, $caseDraftSuitParty->type);
        $this->assertEquals($case_draft->id, $caseDraftSuitParty->case_draft_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $caseDraftSuitParty = CaseDraftSuitParty::factory()->create();

        $response = $this->delete(route('case-draft-suit-party.destroy', $caseDraftSuitParty));

        $response->assertNoContent();

        $this->assertSoftDeleted($caseDraftSuitParty);
    }
}
