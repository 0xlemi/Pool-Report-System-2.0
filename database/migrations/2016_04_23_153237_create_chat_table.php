<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('report_id')->unsigned()->index()->nullable()->default(null);
            $table->integer('technician_id')->unsigned()->index()->nullable()->default(null);
            $table->integer('supervisor_id')->unsigned()->index()->nullable()->default(null);
            $table->integer('client_id')->unsigned()->index()->nullable()->default(null);
            $table->text('comment');
            $table->integer('chat_id_parent')->unsigned()->index()->nullable()->default(null);
            $table->timestamps();
        });

        Schema::table('chat', function(Blueprint $table){
            $table->foreign('chat_id_parent')
                ->references('id')
                ->on('chat')
                ->onDelete('cascade');

            $table->foreign('report_id')
                ->references('id')
                ->on('reports')
                ->onDelete('cascade');

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
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
        Schema::drop('chat');
    }
}
