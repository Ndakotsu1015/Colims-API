<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Chart;
use App\Models\ChartCategory;
use App\Models\ChartType;
use App\Models\DashboardSetting;
use App\Models\Module;

class DashboardSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DashboardSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'chart_title' => $this->faker->word,
            'is_active' => $this->faker->boolean,
            'orderby' => $this->faker->randomNumber(),
            'is_group' => $this->faker->boolean,
            'sub_module_id' => $this->faker->randomNumber(),
            'chart_id' => Chart::factory(),
            'module_id' => Module::factory(),
            'chart_type_id' => ChartType::inRandomOrder()->first(),
            'chart_category_id' => ChartCategory::inRandomOrder()->first(),
        ];
    }
}
