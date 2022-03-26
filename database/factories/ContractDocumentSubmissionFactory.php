<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AwardLetter;
use App\Models\ContractDocumentSubmission;

class ContractDocumentSubmissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContractDocumentSubmission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'is_submitted' => $this->faker->boolean,
            'is_approved' => $this->faker->boolean,
            'due_date' => $this->faker->date(),
            'award_letter_id' => AwardLetter::factory(),
            'url_token' => Str::random(10),
            'access_code' => Str::random(10),
        ];
    }
}
