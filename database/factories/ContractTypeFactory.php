<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ContractType;

class ContractTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContractType::class;

    public static $contractTypes = [
        [1, "Fixed Price Contract (FP)"],
        [2, "Time and Material Contract (TMC)"],
        [3, "Labour Contract (LC)"],
        [4, "Subcontractor Contract (SC)"],
        [5, "Cost Reimbursable Contract (CR)"],
        [6, "Other Contract (OC)"],
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $contractType =  $this->faker->unique()->randomElement(self::$contractTypes);
        return [
            'id' => $contractType[0],
            'name' => $contractType[1],
        ];
    }
}
