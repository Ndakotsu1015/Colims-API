<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CaseActivity;
use App\Models\CaseStatus;
use App\Models\CourtCase;
use App\Models\Solicitor;
use App\Models\User;

class CaseActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CaseActivity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text,
            'court_case_id' => CourtCase::factory(),
            'user_id' => User::factory(),
            'solicitor_id' => Solicitor::factory(),
            'case_status_id' => CaseStatus::inRandomOrder()->first()->id,
            'location' => $this->faker->word,
            'court_pronouncement' => $this->faker->word,
            'next_adjourned_date' => $this->faker->dateTime(),
        ];
    }
}
