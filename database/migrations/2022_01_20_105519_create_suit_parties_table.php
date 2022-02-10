<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuitPartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('suit_parties', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('phone_no');
            $table->text('residential_address');
            $table->foreignId('court_case_id')->constrained();
            $table->foreignId('case_participant_id')->constrained();
            $table->string('type');
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
        Schema::dropIfExists('suit_parties');
    }
}
