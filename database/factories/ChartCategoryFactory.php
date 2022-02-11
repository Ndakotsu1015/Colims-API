<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ChartCategory;
use App\Models\ChartProvider;

class ChartCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ChartCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'chart_category' => $this->faker->word,
            'chart_provider_id' => ChartProvider::inRandomOrder()->first(),
        ];
    }
}
