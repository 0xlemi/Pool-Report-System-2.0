<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount', 16, 2);
            $table->enum('method', ['cash', 'transfer', 'check', 'credit_card', 'debit', 'atm_withdrawals', 'connect']);
            $table->boolean('verified')->default(false); // Is this payment was through Stripe connect or not
            $table->integer('invoice_id')->unsigned();
            $table->integer('seq_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
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
        Schema::dropIfExists('payments');
    }
}
