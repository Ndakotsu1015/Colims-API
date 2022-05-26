<?php

namespace Database\Seeders;

use App\Models\Menu;
use Database\Factories\MenuFactory;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Menu::count() > 0) {
            return;
        }
        Menu::withoutEvents(function () {
            Menu::factory(count(MenuFactory::$menus))->create();
        });
    }
}
