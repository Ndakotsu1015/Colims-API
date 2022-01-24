<?php

namespace Database\Seeders;

use App\Models\PrivilegeClass;
use Illuminate\Database\Seeder;

class PrivilegeClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrivilegeClass::factory()->count(5)->create();
    }
}
