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
            $table->string('memo_file')->nullable();
            $table->foreignId('initiator_id')->constrained('users');
            $table->foreignId('case_reviewer_id')->nullable()->constrained('users');
            $table->string('status')->default('pending');
            $table->text('recommendation_note')->nullable();
            $table->boolean('should_go_to_trial')->nullable();
            $table->boolean('is_case_closed')->nullable();
            $table->string('recommendation_note_file')->nullable();
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
