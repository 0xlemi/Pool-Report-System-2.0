<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechnicianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('last_name');
            $table->string('cellphone');
            $table->string('address');
            $table->string('username')->unique()->index();
            $table->string('password');
            $table->string('image');
            $table->string('tn_image');
            $table->text('comments');
            $table->integer('supervisor_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('technicians', function(Blueprint $table){
            $table->foreign('supervisor_id')
                ->references('id')
                ->on('supervisors')
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
        Schema::drop('technicians');
    }
}
