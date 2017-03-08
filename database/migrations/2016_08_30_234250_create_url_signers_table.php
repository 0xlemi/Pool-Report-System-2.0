<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlSignersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('url_signers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('email')->index();
            // $table->string('user_id')->unsigned();
            $table->string('token')->index();
            $table->timestamp('expire');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();

            // $table->timestamps();
            // $table->foreign('user_id')
            //     ->references('id')
            //     ->on('users')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('url_signers');
    }
}
