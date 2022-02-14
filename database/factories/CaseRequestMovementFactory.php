<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CaseRequest;
use App\Models\CaseRequestMovement;
use App\Models\User;

class CaseRequestMovementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CaseRequestMovement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'case_request_id' => CaseRequest::factory(),
            'user_id' => User::factory(),
            'forward_to' => User::factory(),
            'notes' => $this->faker->text,
        ];
    }
}
