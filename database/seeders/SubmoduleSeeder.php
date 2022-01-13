<?php

namespace Database\Seeders;

use App\Models\Submodule;
use Illuminate\Database\Seeder;

class SubmoduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Submodule::factory()->count(5)->create();
    }
}
