<?php

namespace Database\Seeders;

use App\Models\PrivilegeDetail;
use Illuminate\Database\Seeder;

class PrivilegeDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrivilegeDetail::factory()->count(5)->create();
    }
}
