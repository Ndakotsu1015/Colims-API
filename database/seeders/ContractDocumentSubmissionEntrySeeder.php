<?php

namespace Database\Seeders;

use App\Models\ContractDocumentSubmissionEntry;
use Illuminate\Database\Seeder;

class ContractDocumentSubmissionEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractDocumentSubmissionEntry::factory()->count(5)->create();
    }
}
