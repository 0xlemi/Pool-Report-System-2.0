<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlobalMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_measurements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->integer('seq_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->timestamps();

            $table->unique(['name', 'company_id']);
            $table->unique(['seq_id', 'company_id']);

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
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
        Schema::dropIfExists('global_measurements');
    }
}
