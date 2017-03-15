<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceMissingHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missing_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('num_services_missing');
            $table->integer('num_services_done');
            $table->integer('admin_id')->unsigned();
            $table->timestamps();

            $table->unique(['date', 'admin_id']);
            $table->foreign('admin_id')
                ->references('id')
                ->on('administrators')
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
        Schema::dropIfExists('missing_histories');
    }
}
