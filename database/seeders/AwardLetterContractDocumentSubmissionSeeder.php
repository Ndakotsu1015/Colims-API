<?php

namespace Database\Seeders;

use App\Models\AwardLetterContractDocumentSubmission;
use Illuminate\Database\Seeder;

class AwardLetterContractDocumentSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AwardLetterContractDocumentSubmission::factory()->count(5)->create();
    }
}
