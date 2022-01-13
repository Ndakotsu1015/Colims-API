<?php

namespace Database\Seeders;

use App\Models\ChartProvider;
use Illuminate\Database\Seeder;

class ChartProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChartProvider::factory()->count(5)->create();
    }
}
