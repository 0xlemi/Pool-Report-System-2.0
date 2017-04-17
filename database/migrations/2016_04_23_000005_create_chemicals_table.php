<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChemicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chemicals', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount', 9, 2);
            $table->integer('global_chemical_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->timestamps();

            $table->unique(['global_chemical_id', 'service_id']);

            $table->foreign('global_chemical_id')
                ->references('id')
                ->on('global_chemicals')
                ->onDelete('cascade');
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
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
        Schema::dropIfExists('chemicals');
    }
}
