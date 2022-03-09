<?php

namespace Database\Seeders;

use App\Models\ContractCategory;
use Database\Factories\ContractCategoryFactory;
use Illuminate\Database\Seeder;

class ContractCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractCategory::factory(count(ContractCategoryFactory::$contractCategories))->create();
    }
}
