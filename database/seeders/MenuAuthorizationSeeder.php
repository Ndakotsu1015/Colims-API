<?php

namespace Database\Seeders;

use App\Models\MenuAuthorization;
use Illuminate\Database\Seeder;

class MenuAuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuAuthorization::factory()->count(5)->create();
    }
}
