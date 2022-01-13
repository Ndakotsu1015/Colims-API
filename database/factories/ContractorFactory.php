<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Contractor;

class ContractorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contractor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contractor_name' => $this->faker->word,
            'address' => $this->faker->word,
            'location' => $this->faker->word,
            'email' => $this->faker->safeEmail,
            'phone_no' => $this->faker->word,
            'contact_name' => $this->faker->word,
            'contact_email' => $this->faker->word,
            'contact_phone' => $this->faker->word,
        ];
    }
}
