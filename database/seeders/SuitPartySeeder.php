<?php

namespace Database\Seeders;

use App\Models\SuitParty;
use Illuminate\Database\Seeder;

class SuitPartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SuitParty::factory()->count(5)->create();
    }
}
