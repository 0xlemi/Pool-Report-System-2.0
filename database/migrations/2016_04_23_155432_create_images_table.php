<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('report_id')->unsigned()->index()->nullable()->default(null);
            $table->integer('technician_id')->unsigned()->index()->nullable()->default(null);
            $table->integer('supervisor_id')->unsigned()->index()->nullable()->default(null);
            $table->integer('client_id')->unsigned()->index()->nullable()->default(null);
            $table->integer('service_id')->unsigned()->index()->nullable()->default(null);
            $table->string('path');
            $table->char('type', 1)->default('N'); // N=normal, T=thumbnail, S=icon
            $table->smallInteger('order')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('images', function(Blueprint $table){
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');

            $table->foreign('report_id')
                ->references('id')
                ->on('reports')
                ->onDelete('restrict');

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('restrict');

            $table->foreign('supervisor_id')
                ->references('id')
                ->on('supervisors')
                ->onDelete('restrict');

            $table->foreign('technician_id')
                ->references('id')
                ->on('technicians')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('images');
    }
}
