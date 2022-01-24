<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAwardLetterFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('award_letters', function (Blueprint $table) {
            $table->string('contract_title');
            $table->text('contract_detail');
            $table->unsignedBigInteger('duration_id')->index();
            $table->foreign('duration_id')->references('id')->on('durations')->onDelete('cascade');            
            $table->unsignedBigInteger('contract_category_id')->index();
            $table->foreign('contract_category_id')->references('id')->on('contract_categories')->onDelete('cascade');                                
        });
    }                         

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
