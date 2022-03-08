<?php

namespace Database\Seeders;

use App\Models\ContractType;
use Database\Factories\ContractTypeFactory;
use Illuminate\Database\Seeder;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        ContractType::factory(count(ContractTypeFactory::$contractTypes))->create();
    }
}
