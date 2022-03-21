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
            'contract_sum' => $this->faker->numberBetween(0,9999999999),                   
            'date_awarded' => $this->faker->date(),
            'last_bank_ref_date' => $this->faker->date(),
            'reference_no' => $this->faker->unique()->asciify("ref****"),            
            'contract_title' => $this->faker->word(),
            // 'contract_detail' => $this->faker->word(),            
            'contract_type_id' => ContractType::inRandomOrder()->first(),            
            'duration_id' => Duration::inRandomOrder()->first(),
            // 'contract_category_id' => ContractCategory::inRandomOrder()->first(),
            'contractor_id' => Contractor::factory(),
            // 'project_location' => $this->faker->word(),            
            'project_id' => Project::inRandomOrder()->first(),
            'approved_by' => Employee::factory(),
            'commencement_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),            
        ];
    }
}
