<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Chart;
use App\Models\ChartCategory;
use App\Models\ChartType;
use App\Models\Module;

class ChartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'chart_title' => $this->faker->word,
            'sql_query' => $this->faker->word,
            'is_active' => $this->faker->boolean,
            'module_id' => Module::factory(),
            'filter_column' => $this->faker->word,
            'chart_type_id' => ChartType::inRandomOrder()->first(),
            'chart_category_id' => ChartCategory::inRandomOrder()->first(),
        ];
    }
}
