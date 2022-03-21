<?php

namespace Database\Seeders;

use App\Models\AwardLetterContractDocumentSubmissionEntry;
use Illuminate\Database\Seeder;

class AwardLetterContractDocumentSubmissionEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AwardLetterContractDocumentSubmissionEntry::factory()->count(5)->create();
    }
}
