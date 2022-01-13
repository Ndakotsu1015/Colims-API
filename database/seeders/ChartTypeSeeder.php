<?php

namespace Database\Seeders;

use App\Models\ChartType;
use Illuminate\Database\Seeder;

class ChartTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChartType::factory()->count(5)->create();
    }
}
