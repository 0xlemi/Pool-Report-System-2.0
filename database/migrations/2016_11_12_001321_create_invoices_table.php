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
            $table->text('description')->nullable();
            $table->dateTime('pay_before');
            $table->morphs('invoiceable');
            $table->integer('seq_id')->unsigned()->index();
            $table->integer('company_id')->unsigned();
            $table->timestamps();

            $table->unique(['seq_id', 'company_id']);

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });

        DB::unprepared('
            ALTER TABLE invoices
                ADD CHECK (invoiceable_type IN (
                    \'App\WorkOrder\',
                    \'App\ServiceContract\'
                ));
        ');
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
