<?php

namespace Database\Seeders;

use App\Models\CaseActivitySuitParty;
use App\Models\CaseParticipant;
use App\Models\CaseRequestMovement;
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
            ContractTypeSeeder::class,
            ContractCategorySeeder::class,
            StateSeeder::class,     
            ProjectSeeder::class,       
            AwardLetterSeeder::class,
            BankReferenceSeeder::class,
            BankSeeder::class,
            CalendarEventSeeder::class,
            CaseActivitySeeder::class,
            ChartProviderSeeder::class,
            ChartCategorySeeder::class,  
            ChartTypeSeeder::class,          
            ChartSeeder::class,                        
            ContractorAffliateSeeder::class,
            ContractorSeeder::class,            
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
            CaseRequestMovementSeeder::class,
            CaseRequestSeeder::class,
            PropertyTypeSeeder::class,            
            SubmoduleSeeder::class,
            CaseParticipantSeeder::class,
            SuitPartySeeder::class,
            CaseStatusSeeder::class,            
            LegalDocumentTypeSeeder::class,
            CaseActivitySuitPartySeeder::class,
        ]);
    }
}
