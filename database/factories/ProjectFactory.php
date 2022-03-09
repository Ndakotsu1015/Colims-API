<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Project;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    public static $projects = [
        [1, "Support To Peace And Security Through The Joint Police Programme In Nigeria", "P2091"],
        [2, "Powell River Recreation Complex Heat Recovery Project","P84993"],
        [3, "Light Capital Paving From Beginning At Route 180 And Extending North 12.45 Miles To Route 9", "P35562"],
        [4, "Health Science Education Center", "P090339"],
        [5, "Construct Bridge At Kababu- Kibumburia At Magoto River", "P0998877"],        
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $project =  $this->faker->unique()->randomElement(self::$projects);
        return [
            'id' => $project[0],
            'name' => $project[1],
            'project_code' => $project[2],
        ];
    }
}
