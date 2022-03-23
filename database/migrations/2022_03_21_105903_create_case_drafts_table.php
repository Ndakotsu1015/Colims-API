<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('case_drafts', function (Blueprint $table) {
            $table->id();
            $table->string('case_no')->nullable();
            $table->string('title')->nullable();
            $table->boolean('dls_approved')->nullable();
            $table->boolean('review_submitted')->default(false);
            $table->string('review_comment')->nullable();
            $table->foreignId('handler_id')->nullable()->constrained('users');
            $table->foreignId('solicitor_id')->nullable()->constrained();
            $table->foreignId('case_request_id')->constrained();
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
        Schema::dropIfExists('case_drafts');
    }
}
