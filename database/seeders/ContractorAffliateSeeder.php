<?php

namespace Database\Seeders;

use App\Models\ContractorAffliate;
use Illuminate\Database\Seeder;

class ContractorAffliateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractorAffliate::factory()->count(5)->create();
    }
}
