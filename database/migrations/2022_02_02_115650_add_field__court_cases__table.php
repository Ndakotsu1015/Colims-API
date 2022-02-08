<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldCourtCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('court_cases', function (Blueprint $table) {
            // $table->foreignId('case_status_id')->constrained();  
            // $table->foreignId('case_outcome_id')->constrained();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('court_cases', function (Blueprint $table) {
            //
        });
    }
}
