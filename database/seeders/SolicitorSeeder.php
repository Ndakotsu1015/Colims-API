<?php

namespace Database\Seeders;

use App\Models\Solicitor;
use Illuminate\Database\Seeder;

class SolicitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Solicitor::factory()->count(5)->create();
    }
}
