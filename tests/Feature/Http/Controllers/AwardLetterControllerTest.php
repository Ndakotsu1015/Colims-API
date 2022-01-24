<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\AwardLetter;
use App\Models\ContractCategory;
use App\Models\Contractor;
use App\Models\ContractType;
use App\Models\Duration;
use App\Models\Project;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AwardLetterController
 */
class AwardLetterControllerTest extends TestCase
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
        $awardLetters = AwardLetter::factory()->count(3)->create();

        $response = $this->get(route('award-letter.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AwardLetterController::class,
            'store',
            \App\Http\Requests\AwardLetterStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $unit_price = $this->faker->randomFloat(/** float_attributes **/);
        $no_units = $this->faker->randomNumber();
        $no_rooms = $this->faker->randomNumber();
        $date_awarded = $this->faker->date();
        $reference_no = $this->faker->word;
        $award_no = $this->faker->randomNumber();
        $volume_no = $this->faker->randomDigit()+1;
        $contract_title = $this->faker->word;
        $contract_detail = $this->faker->word;
        $duration = Duration::factory()->create();
        $contract_category = ContractType::factory()->create();
        $contractor = Contractor::factory()->create();
        $contract_type = ContractType::factory()->create();
        $state = State::factory()->create();
        $project = Project::factory()->create();
        $posted_by = $this->faker->randomNumber();        

        $response = $this->post(route('award-letter.store'), [
            'unit_price' => $unit_price,
            'no_units' => $no_units,
            'no_rooms' => $no_rooms,
            'date_awarded' => $date_awarded,
            'reference_no' => $reference_no,
            'award_no' => $award_no,
            'volume_no' => $volume_no,
            'contractor_id' => $contractor->id,
            'contract_type_id' => $contract_type->id,
            'contract_category_id' => $contract_category->id,
            'contract_title' => $contract_title,
            'contract_detail' => $contract_detail,
            'duration_id' => $duration->id,
            'state_id' => $state->id,
            'project_id' => $project->id,
            'posted_by' => $posted_by,
        ]);

        $awardLetters = AwardLetter::query()
            ->where('unit_price', $unit_price)
            ->where('no_units', $no_units)
            ->where('no_rooms', $no_rooms)
            ->where('date_awarded', Carbon::parse($date_awarded))
            ->where('reference_no', $reference_no)
            ->where('award_no', $award_no)
            ->where('volume_no', $volume_no)
            ->where('contractor_id', $contractor->id)
            ->where('contract_type_id', $contract_type->id)
            ->where('contract_category_id', $contract_category->id)
            ->where('contract_title', $contract_title)
            ->where('contract_detail', $contract_detail)
            ->where('duration_id', $duration->id)            
            ->where('state_id', $state->id)
            ->where('project_id', $project->id)
            ->where('posted_by', $posted_by)
            ->get();
        $this->assertCount(1, $awardLetters);
        $awardLetter = $awardLetters->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $awardLetter = AwardLetter::factory()->create();

        $response = $this->get(route('award-letter.show', $awardLetter));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AwardLetterController::class,
            'update',
            \App\Http\Requests\AwardLetterUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $awardLetter = AwardLetter::factory()->create();
        $unit_price = $this->faker->randomFloat(/** float_attributes **/);
        $no_units = $this->faker->randomNumber();
        $no_rooms = $this->faker->randomNumber();
        $date_awarded = $this->faker->date();
        $reference_no = $this->faker->word;
        $award_no = $this->faker->randomNumber();
        $volume_no = $this->faker->randomNumber();
        $contractor = Contractor::factory()->create();
        $contract_type = ContractType::factory()->create();
        $contract_category = ContractCategory::factory()->create();
        $contract_title = $this->faker->word;
        $contract_detail = $this->faker->word;
        $duration = Duration::factory()->create();        
        $state = State::factory()->create();
        $project = Project::factory()->create();
        $posted_by = $this->faker->randomNumber();

        $response = $this->put(route('award-letter.update', $awardLetter), [
            'unit_price' => $unit_price,
            'no_units' => $no_units,
            'no_rooms' => $no_rooms,
            'date_awarded' => $date_awarded,
            'reference_no' => $reference_no,
            'award_no' => $award_no,
            'volume_no' => $volume_no,
            'contractor_id' => $contractor->id,
            'contract_type' => $contract_type->id,
            'contract_category' => $contract_category->id,
            'contract_title' => $contract_title,
            'contract_detail' => $contract_detail,
            'duration' => $duration->id,
            'state_id' => $state->id,
            'project_id' => $project->id,
            'posted_by' => $posted_by,
        ]);

        $awardLetter->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($unit_price, $awardLetter->unit_price);
        $this->assertEquals($no_units, $awardLetter->no_units);
        $this->assertEquals($no_rooms, $awardLetter->no_rooms);
        $this->assertEquals(Carbon::parse($date_awarded), $awardLetter->date_awarded);
        $this->assertEquals($reference_no, $awardLetter->reference_no);
        $this->assertEquals($award_no, $awardLetter->award_no);
        $this->assertEquals($volume_no, $awardLetter->volume_no);
        $this->assertEquals($contractor->id, $awardLetter->contractor_id);
        $this->assertEquals($contract_type->id, $awardLetter->contract_type_id);
        $this->assertEquals($contract_category->id, $awardLetter->contract_category_id);
        $this->assertEquals($contract_title, $awardLetter->contract_title);
        $this->assertEquals($contract_detail, $awardLetter->contract_detail);
        $this->assertEquals($duration->id, $awardLetter->duration_id);        
        $this->assertEquals($state->id, $awardLetter->state_id);
        $this->assertEquals($project->id, $awardLetter->project_id);
        $this->assertEquals($posted_by, $awardLetter->posted_by);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $awardLetter = AwardLetter::factory()->create();

        $response = $this->delete(route('award-letter.destroy', $awardLetter));

        $response->assertNoContent();

        $this->assertSoftDeleted($awardLetter);
    }
}
