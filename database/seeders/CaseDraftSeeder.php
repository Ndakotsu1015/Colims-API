<?php

namespace Database\Seeders;

use App\Models\CaseDraft;
use Illuminate\Database\Seeder;

class CaseDraftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CaseDraft::factory()->count(5)->create();
    }
}
