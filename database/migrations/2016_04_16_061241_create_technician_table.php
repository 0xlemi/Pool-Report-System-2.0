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
            $table->char('language', 2);
            $table->text('comments');
            $table->integer('email_preferences');
            $table->integer('supervisor_id')->unsigned();
            $table->integer('seq_id')->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('technicians', function(Blueprint $table){
            $table->foreign('supervisor_id')
                ->references('id')
                ->on('supervisors')
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
        Schema::drop('technicians');
    }
}
