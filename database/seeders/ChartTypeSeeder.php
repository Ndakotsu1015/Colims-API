<?php

namespace Database\Seeders;

use App\Models\ChartType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        DB::table('chart_types')->insert([
            [                
                'chart_category_id' => 1,
                'chart_type' => 'bar',
            ],            
            [                
                'chart_category_id' => 2,
                'chart_type' => 'doughnut',
            ], 
            [                
                'chart_category_id' => 1,
                'chart_type' => 'spline',
            ], 
            [                
                'chart_category_id' => 1,
                'chart_type' => 'stepline',
            ], 
            [                
                'chart_category_id' => 3,
                'chart_type' => 'rangeBar',
            ], 
            [                
                'chart_category_id' => 4,
                'chart_type' => 'grid',
            ], 
        ]);
    }
}
