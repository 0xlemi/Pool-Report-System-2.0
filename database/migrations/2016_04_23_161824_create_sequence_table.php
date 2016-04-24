<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSequenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Reason for this table is to have consecutive id's for each user.
         * Not a confusing shared id between companies
         */
        Schema::create('seq', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('name', 50);
            $table->integer('user_id');
            $table->integer('val')->unsigned();
            $table->primary(['name', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('seq');
    }
}
