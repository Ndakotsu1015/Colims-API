<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('charts', function (Blueprint $table) {
            $table->id();
            $table->string('chart_title');
            $table->string('sql_query');
            $table->boolean('is_active')->default(true);
            $table->foreignId('module_id')->constrained();
            $table->string('filter_column');
            $table->foreignId('chart_type_id')->constrained();
            $table->foreignId('chart_category_id')->constrained();
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
        Schema::dropIfExists('charts');
    }
}
