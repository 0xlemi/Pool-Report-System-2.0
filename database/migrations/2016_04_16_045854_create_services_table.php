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
            $table->decimal('latitude', 9, 6);
            $table->decimal('longitude', 9, 6);
            $table->string('address_line');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->char('country', 2);
            $table->text('comments');
            $table->integer('admin_id')->unsigned();
            $table->integer('seq_id')->unsigned()->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('services', function(Blueprint $table){
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
        Schema::drop('services');
    }
}
