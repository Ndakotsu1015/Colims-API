<?php

namespace Database\Seeders;

use App\Models\CaseActivity;
use Illuminate\Database\Seeder;

class CaseActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CaseActivity::factory()->count(5)->create();
    }
}
