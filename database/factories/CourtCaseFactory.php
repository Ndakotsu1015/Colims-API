<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CourtCase;
use App\Models\User;

class CourtCaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourtCase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'case_no' => $this->faker->randomNumber(),
            'status' => $this->faker->word,
            'handler_id' => User::factory(),
            'posted_by' => User::factory(),
        ];
    }
}
