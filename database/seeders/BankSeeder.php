<?php

namespace Database\Seeders;

use App\Models\Bank;
use Database\Factories\BankFactory;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        Bank::factory(10)->create();
        // Bank::factory(count(BankFactory::$banks))->create();
    }
}
