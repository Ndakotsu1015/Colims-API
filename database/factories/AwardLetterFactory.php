<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AwardLetter;
use App\Models\Contractor;
use App\Models\Project;
use App\Models\PropertyType;
use App\Models\State;

class AwardLetterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AwardLetter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'unit_price' => $this->faker->randomFloat(0, 0, 9999999999.),
            'no_units' => $this->faker->randomNumber(),
            'no_rooms' => $this->faker->randomNumber(),
            'date_awarded' => $this->faker->date(),
            'reference_no' => $this->faker->word,
            'award_no' => $this->faker->randomNumber(),
            'volume_no' => $this->faker->randomNumber(),
            'contractor_id' => Contractor::factory(),
            'property_type_id' => PropertyType::factory(),
            'state_id' => State::factory(),
            'project_id' => Project::factory(),
            'posted_by' => $this->faker->randomNumber(),
        ];
    }
}
