<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'full_name' => $this->faker->word,
            'title' => $this->faker->sentence(4),
            'designation' => $this->faker->word,
            'signature_file' => 'https://picsum.photos/seed/signature/200/200',
        ];
    }

    private function getRandomImageName(): string
    {
        $number = random_int(1, 5);

        return "image$number.jpg";
    }
}
