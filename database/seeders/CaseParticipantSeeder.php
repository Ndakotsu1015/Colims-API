<?php

namespace Database\Seeders;

use App\Models\CaseParticipant;
use Illuminate\Database\Seeder;

class CaseParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CaseParticipant::factory()->count(5)->create();
    }
}
