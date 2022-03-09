<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ContractCategory;

class ContractCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContractCategory::class;

    public static $contractCategories = [
        [1, "Centralized Database Management System (ACDHH) - Amendment 1"],
        [2, "Cloud Services"],
        [3, "Data Center Services"],
        [4, "Data Management Services"],
        [5, "Document Management Services"],    
    ];


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $contractCategory =  $this->faker->unique()->randomElement(self::$contractCategories);
        return [
            'id' => $contractCategory[0],
            'name' => $contractCategory[1],
        ];
    }
}
