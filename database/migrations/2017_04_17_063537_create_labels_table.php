<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('color')->default('ADB7BE');
            $table->tinyInteger('value')->unsigned()->default(1);
            $table->integer('global_chemical_id')->unsigned();
            $table->timestamps();

            $table->unique(['value', 'global_chemical_id']);

            $table->foreign('global_chemical_id')
                ->references('id')
                ->on('global_chemicals')
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
        Schema::dropIfExists('labels');
    }
}
