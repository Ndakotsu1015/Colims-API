<?php

namespace Database\Seeders;

use App\Models\ContractDocumentType;
use Database\Factories\ContractDocumentTypeFactory;
use Illuminate\Database\Seeder;

class ContractDocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Project::factory(count(ProjectFactory::$projects))->create();
        ContractDocumentType::factory(count(ContractDocumentTypeFactory::$contractDocumentTypes))->create();
    }
}
