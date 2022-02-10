<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CaseParticipant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CaseParticipantController
 */
class CaseParticipantControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $caseParticipants = CaseParticipant::factory()->count(3)->create();

        $response = $this->get(route('case-participant.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseParticipantController::class,
            'store',
            \App\Http\Requests\CaseParticipantStoreRequest::class
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

        $response = $this->post(route('case-participant.store'), [
            'name' => $name,
            'phone_no' => $phone_no,
            'address' => $address,
            'email' => $email,
        ]);

        $caseParticipants = CaseParticipant::query()
            ->where('name', $name)
            ->where('phone_no', $phone_no)
            ->where('address', $address)
            ->where('email', $email)
            ->get();
        $this->assertCount(1, $caseParticipants);
        $caseParticipant = $caseParticipants->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $caseParticipant = CaseParticipant::factory()->create();

        $response = $this->get(route('case-participant.show', $caseParticipant));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseParticipantController::class,
            'update',
            \App\Http\Requests\CaseParticipantUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $caseParticipant = CaseParticipant::factory()->create();
        $name = $this->faker->name;
        $phone_no = $this->faker->word;
        $address = $this->faker->word;
        $email = $this->faker->safeEmail;

        $response = $this->put(route('case-participant.update', $caseParticipant), [
            'name' => $name,
            'phone_no' => $phone_no,
            'address' => $address,
            'email' => $email,
        ]);

        $caseParticipant->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $caseParticipant->name);
        $this->assertEquals($phone_no, $caseParticipant->phone_no);
        $this->assertEquals($address, $caseParticipant->address);
        $this->assertEquals($email, $caseParticipant->email);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $caseParticipant = CaseParticipant::factory()->create();

        $response = $this->delete(route('case-participant.destroy', $caseParticipant));

        $response->assertNoContent();

        $this->assertSoftDeleted($caseParticipant);
    }
}
