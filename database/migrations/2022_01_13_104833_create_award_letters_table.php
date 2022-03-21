<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('award_letters', function (Blueprint $table) {
            $table->id();                               
            $table->date('date_awarded');            
            $table->date('last_bank_ref_date')->nullable();
            $table->string('reference_no')->unique();            
            $table->foreignId('contractor_id')->constrained();
            $table->foreignId('contract_type_id')->constrained();
            // $table->string('project_location')->nullable();            
            $table->foreignId('project_id')->constrained();            
            $table->foreignId('approved_by')->constrained('employees');
            $table->date('commencement_date');
            $table->date('due_date');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('award_letters');
    }
}
