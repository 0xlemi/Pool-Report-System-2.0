<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('address_line_1');
            $table->string('address_line_2');
            $table->string('state');
            $table->integer('postal_code');
            $table->string('country');
            $table->tinyInteger('type');
            $table->integer('service_days');
            $table->decimal('amount', 16, 2);
            $table->char('currency', 3);
            $table->integer('start_time');
            $table->integer('end_time');
            $table->boolean('status');
            $table->string('image');
            $table->string('tn_image');
            $table->text('comments');
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('services', function(Blueprint $table){
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::drop('services');
    }
}
