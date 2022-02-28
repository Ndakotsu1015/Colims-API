<?php

namespace Database\Factories;

use App\Models\CaseRequest;
use App\Models\CaseStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CourtCase;
use App\Models\Solicitor;
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
            'is_case_closed' => $this->faker->boolean,            
            'handler_id' => User::factory(),
            'posted_by' => User::factory(),
            'case_status_id' => CaseStatus::factory(),            
            'solicitor_id' => Solicitor::factory(),
            'case_request_id' => CaseRequest::factory(),         
        ];
    }
}
