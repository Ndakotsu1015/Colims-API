<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAwardletterFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('award_letters', function (Blueprint $table) {
        //     // $table->dropForeign('award_letters_property_type_id_foreign');
        //     // $table->dropColumn('property_type_id');
        //     // $table->foreignId('contract_type_id')->constrained();                        
        // });
        // Schema::table('award_letters', function (Blueprint $table) {
        //     // $table->dropForeign('award_letters_property_type_id_foreign');
        //     $table->dropColumn('property_type_id');
        //     // $table->foreignId('contract_type_id')->constrained();                        
        // });
        // Schema::table('award_letters', function (Blueprint $table) {
        //     // $table->dropForeign('award_letters_property_type_id_foreign');
        //     // $table->dropColumn('property_type_id');
        //     $table->foreignId('contract_type_id')->nullable();                        
        // });
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
