<?php

namespace Database\Seeders;

use App\Models\ContractDocumentSubmission;
use Illuminate\Database\Seeder;

class ContractDocumentSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractDocumentSubmission::factory()->count(5)->create();
    }
}
