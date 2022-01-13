<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\State;

class StateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = State::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'state_code' => $this->faker->word,
            'region_id' => $this->faker->randomNumber(),
            'state_code2' => $this->faker->word,
            'is_active' => $this->faker->boolean,
        ];
    }
}
