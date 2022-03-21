<?php

namespace Database\Seeders;

use App\Models\AwardLetterInternalDocument;
use Illuminate\Database\Seeder;

class AwardLetterInternalDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AwardLetterInternalDocument::factory()->count(5)->create();
    }
}
