<?php

namespace Database\Seeders;

use App\Models\LegalDocumentType;
use Illuminate\Database\Seeder;

class LegalDocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LegalDocumentType::factory()->count(5)->create();
    }
}
