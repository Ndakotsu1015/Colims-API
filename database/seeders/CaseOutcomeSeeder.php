<?php

namespace Database\Seeders;

use App\Models\CaseOutcome;
use Illuminate\Database\Seeder;

class CaseOutcomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CaseOutcome::factory()->count(5)->create();
    }
}
