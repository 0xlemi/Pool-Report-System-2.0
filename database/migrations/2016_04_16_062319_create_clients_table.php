<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('last_name');
            $table->string('cellphone');
            $table->string('email')->index();
            $table->string('password');
            $table->tinyInteger('type'); // 1=owner, 2=house administrator
            $table->tinyInteger('email_preferences');
            $table->char('language', 2);
            $table->text('comments');
            $table->integer('seq_id')->index();
            $table->integer('user_id');
            $table->softDeletes();
            $table->timestamps();
        });

        // Schema::table('clients', function(Blueprint $table){
        //     $table->unique(array('user_id', 'email'), 'clients_email_unique');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients');
    }
}
