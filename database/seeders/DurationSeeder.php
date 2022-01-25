<?php

namespace Database\Seeders;

use App\Models\Duration;
use Illuminate\Database\Seeder;

class DurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Duration::factory()->count(5)->create();
    }
}
