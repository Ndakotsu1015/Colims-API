<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Duration;

class DurationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Duration::class;

    public static $durations = [
        [1, "Day", 1],
        [2, "Week", 7],
        [3, "Month", 30],
        [4, "Year", 365],
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $duration = $this->faker->unique()->randomElement(self::$durations);
        return [
            'id' => $duration[0],
            'name' => $duration[1],
            'number_of_days' => $duration[2],
        ];
    }
}
