<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CaseStatus;

class CaseStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CaseStatus::class;

    public static $case_statuses = [
        [1, "Mention"],
        [2, "Motion"],
        [3, "Trial"],
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $case_status =  $this->faker->unique()->randomElement(self::$case_statuses);
        return [
            'id' => $case_status[0],
            'name' => $case_status[1],
        ];
    }
}
