<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnPostedBy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('award_letters', function (Blueprint $table) {
            // $table->dropColumn('posted_by');
            // $table->foreignId('approved_by')->constrained("employees")->nullable();
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
