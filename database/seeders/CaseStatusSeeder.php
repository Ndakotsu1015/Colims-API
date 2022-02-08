<?php

namespace Database\Seeders;

use App\Models\CaseStatus;
use Illuminate\Database\Seeder;

class CaseStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CaseStatus::factory()->count(5)->create();
    }
}
