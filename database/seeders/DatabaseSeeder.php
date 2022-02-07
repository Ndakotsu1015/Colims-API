<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AwardLetterSeeder::class,
            BankReferenceSeeder::class,
            BankSeeder::class,
            CalendarEventSeeder::class,
            CaseActivitySeeder::class,
            ChartProviderSeeder::class,
            ChartCategorySeeder::class,  
            ChartTypeSeeder::class,          
            ChartSeeder::class,            
            ContractCategorySeeder::class,
            ContractorAffliateSeeder::class,
            ContractorSeeder::class,
            ContractTypeSeeder::class,
            CourtCaseSeeder::class,
            DashboardSettingSeeder::class,
            DurationSeeder::class,
            EmployeeSeeder::class,
            LegalDocumentSeeder::class,
            MenuAuthorizationSeeder::class,
            MenuSeeder::class,
            ModuleSeeder::class,
            PrivilegeClassSeeder::class,
            PrivilegeDetailSeeder::class,
            PrivilegeSeeder::class,
            ProjectSeeder::class,
            PropertyTypeSeeder::class,
            StateSeeder::class,
            SubmoduleSeeder::class,
            SuitPartySeeder::class,
            CaseStatusSeeder::class,
            CaseOutcomeSeeder::class,
            LegalDocumentTypeSeeder::class,
        ]);
    }
}
