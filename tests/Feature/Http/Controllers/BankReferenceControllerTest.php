<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\AwardLetter;
use App\Models\BankReference;
use App\Models\ContractorAffliate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BankReferenceController
 */
class BankReferenceControllerTest extends TestCase
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
        $bankReferences = BankReference::factory()->count(3)->create();

        $response = $this->get(route('bank-reference.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BankReferenceController::class,
            'store',
            \App\Http\Requests\BankReferenceStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $reference_date = $this->faker->dateTime();
        $volume_no = $this->faker->randomNumber();
        $reference_no = $this->faker->randomNumber();
        $created_by = $this->faker->randomNumber();
        $in_name_of = $this->faker->word;
        $award_letter = AwardLetter::factory()->create();
        $affiliate = ContractorAffliate::factory()->create();

        $response = $this->post(route('bank-reference.store'), [
            'reference_date' => $reference_date,
            'volume_no' => $volume_no,
            'reference_no' => $reference_no,
            'created_by' => $created_by,
            'in_name_of' => $in_name_of,
            'award_letter_id' => $award_letter->id,
            'affiliate_id' => $affiliate->id,
        ]);

        $bankReferences = BankReference::query()
            ->where('reference_date', $reference_date)
            ->where('volume_no', $volume_no)
            ->where('reference_no', $reference_no)
            ->where('created_by', $created_by)
            ->where('in_name_of', $in_name_of)
            ->where('award_letter_id', $award_letter->id)
            ->where('affiliate_id', $affiliate->id)
            ->get();
        $this->assertCount(1, $bankReferences);
        $bankReference = $bankReferences->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $bankReference = BankReference::factory()->create();

        $response = $this->get(route('bank-reference.show', $bankReference));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BankReferenceController::class,
            'update',
            \App\Http\Requests\BankReferenceUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $bankReference = BankReference::factory()->create();
        $reference_date = $this->faker->dateTime();
        $volume_no = $this->faker->randomNumber();
        $reference_no = $this->faker->randomNumber();
        $created_by = $this->faker->randomNumber();
        $in_name_of = $this->faker->word;
        $award_letter = AwardLetter::factory()->create();
        $affiliate = ContractorAffliate::factory()->create();

        $response = $this->put(route('bank-reference.update', $bankReference), [
            'reference_date' => $reference_date,
            'volume_no' => $volume_no,
            'reference_no' => $reference_no,
            'created_by' => $created_by,
            'in_name_of' => $in_name_of,
            'award_letter_id' => $award_letter->id,
            'affiliate_id' => $affiliate->id,
        ]);

        $bankReference->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($reference_date, $bankReference->reference_date);
        $this->assertEquals($volume_no, $bankReference->volume_no);
        $this->assertEquals($reference_no, $bankReference->reference_no);
        $this->assertEquals($created_by, $bankReference->created_by);
        $this->assertEquals($in_name_of, $bankReference->in_name_of);
        $this->assertEquals($award_letter->id, $bankReference->award_letter_id);
        $this->assertEquals($affiliate->id, $bankReference->affiliate_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $bankReference = BankReference::factory()->create();

        $response = $this->delete(route('bank-reference.destroy', $bankReference));

        $response->assertNoContent();

        $this->assertSoftDeleted($bankReference);
    }
}
