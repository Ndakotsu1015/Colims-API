<?php

namespace Database\Seeders;

use App\Models\CaseRequest;
use Illuminate\Database\Seeder;

class CaseRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CaseRequest::factory()->count(5)->create();
    }
}
