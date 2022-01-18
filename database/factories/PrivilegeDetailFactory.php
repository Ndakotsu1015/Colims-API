<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Privilege;
use App\Models\PrivilegeClass;
use App\Models\PrivilegeDetail;
use App\Models\User;

class PrivilegeDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PrivilegeDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'privilege_class_id' => PrivilegeClass::factory(),
            'user_id' => User::factory(),
            'privilege_id' => Privilege::factory(),
        ];
    }
}
