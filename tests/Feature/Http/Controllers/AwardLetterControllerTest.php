<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\AwardLetter;
use App\Models\Contractor;
use App\Models\Project;
use App\Models\PropertyType;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AwardLetterController
 */
class AwardLetterControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

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
        $volume_no = $this->faker->randomNumber();
        $contractor = Contractor::factory()->create();
        $property_type = PropertyType::factory()->create();
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
            'property_type_id' => $property_type->id,
            'state_id' => $state->id,
            'project_id' => $project->id,
            'posted_by' => $posted_by,
        ]);

        $awardLetters = AwardLetter::query()
            ->where('unit_price', $unit_price)
            ->where('no_units', $no_units)
            ->where('no_rooms', $no_rooms)
            ->where('date_awarded', $date_awarded)
            ->where('reference_no', $reference_no)
            ->where('award_no', $award_no)
            ->where('volume_no', $volume_no)
            ->where('contractor_id', $contractor->id)
            ->where('property_type_id', $property_type->id)
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
        $property_type = PropertyType::factory()->create();
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
            'property_type_id' => $property_type->id,
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
        $this->assertEquals($property_type->id, $awardLetter->property_type_id);
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
