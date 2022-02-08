<?php

namespace Database\Seeders;

use App\Models\ChartProvider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ChartProvider::factory()->count(5)->create();
        DB::table('chart_providers')->insert([
            [
                'chart_provider' => 'Devextreme'
            ], 
        ]);
    }
}
