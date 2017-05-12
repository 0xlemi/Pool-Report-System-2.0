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
            $table->integer('measurement_id')->unsigned();
            $table->timestamps();

            $table->unique(['report_id', 'measurement_id']);

            $table->foreign('report_id')
                ->references('id')
                ->on('reports')
                ->onDelete('cascade');
            $table->foreign('measurement_id')
                ->references('id')
                ->on('measurements')
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
