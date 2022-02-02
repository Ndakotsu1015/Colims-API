<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AwardLetter;
use App\Models\ContractCategory;
use App\Models\Contractor;
use App\Models\ContractType;
use App\Models\Duration;
use App\Models\Employee;
use App\Models\Project;
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
            'unit_price' => $this->faker->numberBetween(0,9999999999),
            'contract_sum' => $this->faker->numberBetween(0,9999999999),
            'no_units' => $this->faker->randomNumber(),            
            'date_awarded' => $this->faker->date(),
            'reference_no' => $this->faker->word,
            'award_no' => $this->faker->randomNumber(),
            'volume_no' => $this->faker->randomNumber(),
            'contract_title' => $this->faker->word(),
            'contract_detail' => $this->faker->word(),            
            'contract_type_id' => ContractType::factory(),            
            'duration_id' => Duration::factory(),
            'contract_category_id' => ContractCategory::factory(),
            'contractor_id' => Contractor::factory(),
            'state_id' => State::factory(),
            'project_id' => Project::factory(),
            'approved_by' => Employee::factory(),
        ];
    }
}
