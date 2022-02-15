<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AwardLetter;
use App\Models\BankReference;
use App\Models\ContractorAffliate;

class BankReferenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BankReference::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reference_date' => $this->faker->dateTime(),            
            'reference_no' => $this->faker->unique()->asciify("ref****"),
            'created_by' => $this->faker->randomNumber(),
            'in_name_of' => $this->faker->word,
            'affiliate_id' => ContractorAffliate::factory(),
            'award_letter_id' => AwardLetter::factory(),
        ];
    }
}
