<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('closed')->nullable()->default(null);
            $table->decimal('amount', 16, 2);
            $table->char('currency', 3);
            $table->string('invoiceable_type');
            $table->integer('invoiceable_id')->unsigned();
            $table->timestamps();
        });

        DB::unprepared("
            ALTER TABLE `invoices`
                ADD CHECK (invoiceable_type IN (
                    'App\WorkOrder',
                    'App\ServiceContract'
                ));
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
