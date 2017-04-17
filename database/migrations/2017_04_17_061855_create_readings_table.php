<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('readings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('value')->unsigned();
            $table->integer('report_id')->unsigned();
            $table->integer('chemical_id')->unsigned();
            $table->timestamps();

            $table->foreign('report_id')
                ->references('id')
                ->on('reports')
                ->onDelete('cascade');
            $table->foreign('chemical_id')
                ->references('id')
                ->on('chemicals')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('readings');
    }
}
