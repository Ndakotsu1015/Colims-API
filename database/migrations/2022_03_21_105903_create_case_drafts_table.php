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
            $table->string('case_no');
            $table->string('title');
            $table->boolean('dls_approved')->nullable();
            $table->boolean('review_submitted')->default(false);
            $table->foreignId('hanler_id')->constrained('user');
            $table->foreignId('solicitor_id')->constrained();
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
