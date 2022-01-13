<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Bank;
use App\Models\ContractorAffliate;

class ContractorAffliateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContractorAffliate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'account_no' => $this->faker->word,
            'account_officer' => $this->faker->word,
            'account_officer_email' => $this->faker->word,
            'bank_address' => $this->faker->word,
            'sort_code' => $this->faker->word,
            'bank_id' => Bank::factory(),
        ];
    }
}
