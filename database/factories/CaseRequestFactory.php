<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CaseRequest;
use App\Models\User;

class CaseRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CaseRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraphs(3, true),
            'request_origin' => $this->faker->word,
            'memo_file' => 'https://picsum.photos/seed/signature/200/200',
            'initiator_id' => User::factory(),
            'case_reviewer_id' => User::factory(),
            'status' => $this->faker->word,
        ];
    }
}
