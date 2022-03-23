<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('case_activities', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->foreignId('court_case_id')->constrained();
            $table->foreignId('user_id')->constrained();            
            $table->foreignId('solicitor_id')->constrained();
            $table->foreignId('case_status_id')->constrained();            
            $table->string('location');
            $table->string('court_pronouncement')->nullable();
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
        Schema::dropIfExists('case_activities');
    }
}
