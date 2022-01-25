<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAdjustApprovedByField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('award_letters', function (Blueprint $table) {
            $table->unsignedBigInteger('approved_by')->index()->change();
            $table->foreign('approved_by')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('award_letters', function (Blueprint $table) {
            //
        });
    }
}
