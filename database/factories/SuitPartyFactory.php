<?php

namespace Database\Factories;

use App\Models\CaseParticipant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CourtCase;
use App\Models\SuitParty;

class SuitPartyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SuitParty::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fullname' => $this->faker->word,
            'phone_no' => $this->faker->word,
            'residential_address' => $this->faker->text,
            'court_case_id' => CourtCase::factory(),
            'case_participant_id' => CaseParticipant::factory(),
            'type' => $this->faker->word,
        ];
    }
}
