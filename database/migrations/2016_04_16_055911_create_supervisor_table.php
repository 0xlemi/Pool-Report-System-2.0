<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupervisorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisors', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('last_name');
            $table->string('cellphone');
            $table->string('address');
            $table->text('comments');
            $table->integer('admin_id')->unsigned();
            $table->integer('seq_id')->index();
            $table->softDeletes();
            $table->rememberToken();
            $table->string('api_token', 60)->unique();
            $table->timestamps();
        });

        Schema::table('supervisors', function(Blueprint $table){
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
        Schema::drop('supervisors');
    }
}
