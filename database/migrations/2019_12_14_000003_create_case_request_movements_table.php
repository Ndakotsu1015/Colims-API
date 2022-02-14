<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseRequestMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('case_request_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_request_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('forward_to')->constrained('users');
            $table->text('notes');
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
        Schema::dropIfExists('case_request_movements');
    }
}
