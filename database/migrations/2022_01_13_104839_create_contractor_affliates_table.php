<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorAffliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('contractor_affliates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('account_no');
            $table->string('account_officer');
            $table->string('account_officer_email');
            $table->string('bank_address');
            $table->string('sort_code');
            $table->foreignId('bank_id')->constrained();
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
        Schema::dropIfExists('contractor_affliates');
    }
}
