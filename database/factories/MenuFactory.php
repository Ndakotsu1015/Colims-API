<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Menu;
use App\Models\Module;

class MenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Menu::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'link' => $this->faker->word,
            'order' => $this->faker->word,
            'is_active' => $this->faker->boolean,
            'icon' => $this->faker->word,
            'parent_id' => Menu::factory(),
            'module_id' => Module::factory(),
        ];
    }
}
