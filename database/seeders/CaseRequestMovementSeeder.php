<?php

namespace Database\Seeders;

use App\Models\CaseRequestMovement;
use Illuminate\Database\Seeder;

class CaseRequestMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CaseRequestMovement::factory()->count(5)->create();
    }
}
