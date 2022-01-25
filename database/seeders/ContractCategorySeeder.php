<?php

namespace Database\Seeders;

use App\Models\ContractCategory;
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
        ContractCategory::factory()->count(5)->create();
    }
}
