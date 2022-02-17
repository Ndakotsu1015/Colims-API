<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CaseParticipant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CaseParticipantController
 */
class CaseParticipantControllerTest extends TestCase
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
        $caseParticipants = CaseParticipant::factory()->count(3)->create();

        $response = $this->get(route('case-participants.index'));

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

        $response = $this->post(route('case-participants.store'), [
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

        $response = $this->get(route('case-participants.show', $caseParticipant));

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
        $caseParticipant = CaseParticipant::inRandomOrder()->first();
        $name = $this->faker->name;
        $phone_no = $this->faker->word;
        $address = $this->faker->word;
        $email = $this->faker->safeEmail;

        $response = $this->put(route('case-participants.update', $caseParticipant), [
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

        $response = $this->delete(route('case-participants.destroy', $caseParticipant));

        $response->assertNoContent();

        $this->assertSoftDeleted($caseParticipant);
    }
}
