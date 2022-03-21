<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ContractDocumentSubmission;
use App\Models\ContractDocumentSubmissionEntry;

class ContractDocumentSubmissionEntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContractDocumentSubmissionEntry::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'filename' => $this->faker->word,
            'is_approved' => $this->faker->boolean,
            'entry_id' => ContractDocumentSubmission::inRandomOrder()->first(),
        ];
    }
}
