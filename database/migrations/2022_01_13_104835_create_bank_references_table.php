<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('bank_references', function (Blueprint $table) {
            $table->id();
            $table->dateTime('reference_date');            
            $table->unsignedInteger('reference_no');
            $table->unsignedInteger('created_by');
            $table->string('in_name_of');            
            $table->foreignId('affiliate_id')->constrained("contractor_affliates");
            $table->foreignId('award_letter_id')->constrained();
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
        Schema::dropIfExists('bank_references');
    }
}
