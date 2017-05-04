<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlobalProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('brand')->nullable()->default(null);
            $table->string('type')->nullable()->default(null);
            $table->string('units');
            $table->decimal('unit_price', 16, 2);
            $table->char('unit_currency', 3);
            $table->text('description');

            $table->integer('seq_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('global_products');
    }
}
