<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CaseActivity;
use App\Models\CaseActivitySuitParty;
use App\Models\SuitParty;

class CaseActivitySuitPartyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CaseActivitySuitParty::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'case_activity_id' => CaseActivity::factory(),
            'suit_party_id' => SuitParty::factory(),
        ];
    }
}
