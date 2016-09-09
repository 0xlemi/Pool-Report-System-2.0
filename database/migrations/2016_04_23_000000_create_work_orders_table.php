<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->boolean('finished');
            $table->decimal('price', 16, 2);
            $table->char('currency', 3);
            $table->integer('service_id')->unsigned();
            $table->integer('supervisor_id')->unsigned();
            $table->integer('technician_id')->unsigned();
            $table->integer('seq_id')->index();
            $table->timestamps();
        });

        Schema::table('work_orders', function(Blueprint $table){
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');
            $table->foreign('supervisor_id')
                ->references('id')
                ->on('supervisors')
                ->onDelete('cascade');
            $table->foreign('technician_id')
                ->references('id')
                ->on('technicians')
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
        Schema::drop('work_orders');
    }
}
