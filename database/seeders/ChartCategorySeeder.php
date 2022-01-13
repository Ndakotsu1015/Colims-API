<?php

namespace Database\Seeders;

use App\Models\ChartCategory;
use Illuminate\Database\Seeder;

class ChartCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChartCategory::factory()->count(5)->create();
    }
}
