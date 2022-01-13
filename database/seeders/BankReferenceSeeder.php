<?php

namespace Database\Seeders;

use App\Models\BankReference;
use Illuminate\Database\Seeder;

class BankReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BankReference::factory()->count(5)->create();
    }
}
