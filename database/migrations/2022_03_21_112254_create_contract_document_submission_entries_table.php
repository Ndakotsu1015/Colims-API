<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractDocumentSubmissionEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('contract_document_submission_entries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('filename');
            $table->boolean('is_approved')->default(false);
            $table->foreignId('entry_id')->constrained('contract_document_submissions');
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
        Schema::dropIfExists('award_letter_contract_document_submission_entries');
    }
}
