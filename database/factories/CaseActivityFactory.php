<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CaseActivity;
use App\Models\CaseOutcome;
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
            'case_outcome_id' => CaseOutcome::factory(),
            'solicitor_id' => Solicitor::factory(),
            'status' => $this->faker->word,
            'location' => $this->faker->word,
        ];
    }
}
