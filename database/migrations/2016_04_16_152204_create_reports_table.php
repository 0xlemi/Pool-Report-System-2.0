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
            $table->tinyInteger('on_time'); // 1=onTime, 2=late, 3=early
            $table->integer('ph');
            $table->integer('clorine')->nullable();
            $table->integer('temperature');
            $table->integer('turbidity');
            $table->integer('salt')->nullable();
            $table->decimal('latitude', 9, 6);
            $table->decimal('longitude', 9, 6);
            $table->decimal('altitude', 8, 2);
            $table->decimal('accuracy', 8, 2);
            $table->integer('service_id')->unsigned();
            $table->integer('technician_id')->unsigned();
            $table->integer('seq_id')->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('reports', function(Blueprint $table){
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
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
        Schema::drop('reports');
    }
}
