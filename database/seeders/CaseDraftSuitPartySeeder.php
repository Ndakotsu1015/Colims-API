<?php

namespace Database\Seeders;

use App\Models\CaseDraftSuitParty;
use Illuminate\Database\Seeder;

class CaseDraftSuitPartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CaseDraftSuitParty::factory()->count(5)->create();
    }
}
