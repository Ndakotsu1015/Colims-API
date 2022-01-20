<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CourtCase;
use App\Models\LegalDocument;
use App\Models\User;

class LegalDocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LegalDocument::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'filename' => $this->faker->word,
            'user_id' => User::factory(),
            'court_case_id' => CourtCase::factory(),
        ];
    }
}
