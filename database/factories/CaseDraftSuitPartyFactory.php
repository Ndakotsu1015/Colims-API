<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CaseDraft;
use App\Models\CaseDraftSuitParty;

class CaseDraftSuitPartyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CaseDraftSuitParty::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone_no' => $this->faker->word,
            'address' => $this->faker->word,
            'email' => $this->faker->safeEmail,
            'type' => $this->faker->word,
            'case_draft_id' => CaseDraft::factory(),
        ];
    }
}
