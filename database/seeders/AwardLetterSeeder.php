<?php

namespace Database\Seeders;

use App\Models\AwardLetter;
use Illuminate\Database\Seeder;

class AwardLetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AwardLetter::factory()->count(5)->create();
    }
}
