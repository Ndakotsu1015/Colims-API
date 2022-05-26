<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Menu;
use App\Models\Module;
use Illuminate\Support\Facades\Log;

class MenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Menu::class;

    public static $menus = [
        [12,"Dashboard","contracts",1,1,"home",null,1],
        [13,"Staff Management","employees",2,1,"users",null,1],
        [14,"Main Navigations","#",3,1,"package",null,1],
        [15,"Award Letter","#",4,1,"award",null,1],
        [16,"Add New","contracts/award-letters/new",1,1,"award",15,1],
        [17,"History","contracts/award-letters/history",2,1,"circle",15,1],
        [18,"test title","/test/testurl",1,1,"book",15,1],
        [19,"test title2","/test/testurl2",4,1,"book",15,1],
        [20,"Menu Settings","#",5,1,"settings",null,1],
        [21,"Menu","menu/menu",1,1,"align-justify",20,1],
        [22,"Menu Authorisation","menu/menuauthorise",2,1,"log-in",20,1],
        [23,"Privilege Manager","#",7,1,"clipboard",null,1],
        [24,"Assign/Revoke Privileges","privilege/privilege-detail",1,1,"lock",23,1],
        [25,"Privilege Setup","#",3,1,"layers",23,1],
        [26,"Privileges","privilege/privilege",1,1,"settings",27,1],
        [27,"Privilege Settings","#",6,1,"settings",null,1],
        [28,"Privilege Class","privilege/privilege-class",2,1,"bar-chart",27,1]
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $menu = $this->faker->unique()->randomElement(self::$menus);
        Log::debug($menu);
        return [
            'id' => $menu[0],
            'title' => $menu[1],
            'link' => $menu[2],
            'order' => $menu[3],
            'is_active' => $menu[4],
            'icon' => $menu[5],
            'parent_id' => $menu[6],
            'module_id' => $menu[7],
            // 'CreatedBy' => \App\Models\Employee::inRandomOrder()->first(),
            'created_at' => date('Y-m-d')
        ];
    }
}
