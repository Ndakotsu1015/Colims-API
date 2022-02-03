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
            $table->float('unit_price',10,0);
            $table->unsignedInteger('no_units');            
            $table->date('date_awarded');
            $table->string('reference_no')->unique();            
            $table->foreignId('contractor_id')->constrained();
            $table->foreignId('property_type_id')->constrained();
            $table->foreignId('state_id')->constrained();
            $table->foreignId('project_id')->constrained();            
            $table->foreignId('approved_by')->constrained('employees');
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
