<?php

namespace Database\Seeders;

use App\Models\ChartCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        DB::table('chart_categories')->insert([
            [
                'chart_provider_id' => 1,
                'chart_category' => 'Bar',
            ], 
            [
                'chart_provider_id' => 1,
                'chart_category' => 'Pie',
            ],
            [
                'chart_provider_id' => 1,
                'chart_category' => 'RangeBar',
            ],
            [
                'chart_provider_id' => 1,
                'chart_category' => 'Grid',
            ]
        ]);
    }
}
