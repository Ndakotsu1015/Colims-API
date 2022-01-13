<?php

namespace Database\Seeders;

use App\Models\DashboardSetting;
use Illuminate\Database\Seeder;

class DashboardSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DashboardSetting::factory()->count(5)->create();
    }
}
