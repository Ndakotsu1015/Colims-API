<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Models\User;

class NotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'subject' => $this->faker->word,
            'content' => $this->faker->paragraphs(3, true),
            'action_link' => $this->faker->word,
            'is_read' => $this->faker->boolean,
        ];
    }
}
