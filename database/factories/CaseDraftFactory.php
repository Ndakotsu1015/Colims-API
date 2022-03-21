<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CaseDraft;
use App\Models\CaseRequest;
use App\Models\Solicitor;
use App\Models\User;

class CaseDraftFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CaseDraft::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'case_no' => $this->faker->word,
            'title' => $this->faker->sentence(4),
            'dls_approved' => $this->faker->boolean,
            'review_submitted' => $this->faker->boolean,
            'hanler_id' => User::factory(),
            'solicitor_id' => Solicitor::factory(),
            'case_request_id' => CaseRequest::factory(),
        ];
    }
}
