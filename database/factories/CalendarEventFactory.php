<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CalendarEvent;
use App\Models\CourtCase;
use App\Models\User;

class CalendarEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CalendarEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text,
            'location' => $this->faker->word,
            'start_time' => $this->faker->dateTime(),
            'end_time' => $this->faker->dateTime(),
            'posted_by' => User::factory(),
            'court_case_id' => CourtCase::factory(),
        ];
    }
}
