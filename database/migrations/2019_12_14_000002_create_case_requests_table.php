<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('case_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('request_origin');
            $table->string('memo_file')->nullable();
            $table->foreignId('initiator_id')->constrained('users');
            $table->string('status');
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
        Schema::dropIfExists('case_requests');
    }
}
