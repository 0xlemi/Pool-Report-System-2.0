<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_contracts', function (Blueprint $table) {
            $table->integer('service_id')->unsigned()->primary(); // same as service_id
            $table->boolean('active')->default(1); // 1=active, 0=inactive
            $table->integer('service_days');
            $table->decimal('amount', 16, 2);
            $table->char('currency', 3);
            $table->time('start_time');
            $table->time('end_time');
            $table->text('comments');
            $table->timestamps();

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
        Schema::dropIfExists('service_contracts');
    }
}
