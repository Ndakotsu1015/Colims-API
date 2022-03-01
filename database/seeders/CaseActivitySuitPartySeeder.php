<?php

namespace Database\Seeders;

use App\Models\CaseActivitySuitParty;
use Illuminate\Database\Seeder;

class CaseActivitySuitPartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CaseActivitySuitParty::factory()->count(5)->create();
    }
}
