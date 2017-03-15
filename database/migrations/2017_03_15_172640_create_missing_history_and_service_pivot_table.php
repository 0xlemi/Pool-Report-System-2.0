<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissingHistoryAndServicePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missing_history_service', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('missing_history_id')->unsigned()->index();
            $table->integer('service_id')->unsigned()->index();
            $table->timestamps();

            $table->primary(['missing_history_id', 'service_id']);
            $table->foreign('missing_history_id')
                ->references('id')
                ->on('missing_histories')
                ->onDelete('cascade');
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
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
        Schema::drop('missing_history_service');
    }
}
