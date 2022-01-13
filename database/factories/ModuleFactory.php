<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Module;

class ModuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Module::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'order_by' => $this->faker->randomNumber(),
            'active_id' => $this->faker->randomNumber(),
            'url' => $this->faker->url,
            'created_by' => $this->faker->randomNumber(),
            'modified_by' => $this->faker->randomNumber(),
            'icon' => $this->faker->word,
            'bg_class' => $this->faker->word,
        ];
    }
}
