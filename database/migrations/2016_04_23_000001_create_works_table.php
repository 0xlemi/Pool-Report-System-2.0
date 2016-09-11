<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->decimal('quantity', 16, 2);
            $table->string('units');
            $table->decimal('cost', 16, 2); // currency is same as work order
            $table->integer('work_order_id')->unsigned();
            $table->integer('technician_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('works', function(Blueprint $table){
            $table->foreign('work_order_id')
                ->references('id')
                ->on('work_orders')
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
        Schema::drop('works');
    }
}
