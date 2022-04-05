<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourtCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('court_cases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('case_no');
            $table->boolean('is_case_closed')->default(false);
            $table->string('court_pronouncement')->nullable();
            $table->foreignId('handler_id')->constrained('users');
            $table->foreignId('posted_by')->constrained('users');
            $table->foreignId('case_status_id')->constrained();
            $table->foreignId('solicitor_id')->constrained();   //solicitor
            $table->foreignId('case_request_id')->constrained();
            $table->string('court_judgement')->nullable();
            $table->integer('court_stage');
            $table->boolean('has_moved')->default(false);
            $table->string('judgement_document_file')->nullable();
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
        Schema::dropIfExists('court_cases');
    }
}
