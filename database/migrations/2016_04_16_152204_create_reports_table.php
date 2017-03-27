<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->dateTime('completed');
            $table->enum('on_time', ['early', 'onTime', 'late', 'noContract']);
            $table->unsignedTinyInteger('ph');
            $table->unsignedTinyInteger('chlorine');
            $table->unsignedTinyInteger('temperature');
            $table->unsignedTinyInteger('turbidity');
            $table->unsignedTinyInteger('salt')->nullable();
            $table->decimal('latitude', 9, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->decimal('altitude', 8, 2)->nullable();
            $table->decimal('accuracy', 8, 2)->nullable();
            $table->integer('service_id')->unsigned();
            $table->integer('user_role_company_id')->unsigned();
            $table->integer('seq_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');
            $table->foreign('user_role_company_id')
                ->references('id')
                ->on('user_role_company')
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
        Schema::drop('reports');
    }
}
