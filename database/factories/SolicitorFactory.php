<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Solicitor;
use App\Models\State;

class SolicitorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Solicitor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'office_address' => $this->faker->word,
            'contact_name' => $this->faker->word,
            'contact_phone' => $this->faker->word,
            'location' => $this->faker->word,
            'state_id' => State::inRandomOrder()->first(),
        ];
    }
}
