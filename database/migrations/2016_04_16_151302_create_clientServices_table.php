<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_service', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('client_id')->unsigned()->index();
            $table->integer('service_id')->unsigned()->index();
            $table->timestamps();
        });

        Schema::table('client_service', function(Blueprint $table){
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
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
        Schema::drop('client_service');
    }
}
