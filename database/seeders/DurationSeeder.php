<?php

namespace Database\Seeders;

use App\Models\Duration;
use Database\Factories\DurationFactory;
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
        Duration::factory(count(DurationFactory::$durations))->create();
    }
}
