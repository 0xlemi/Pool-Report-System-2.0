<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER trg_payments_bi_seq
            BEFORE INSERT ON payments
            FOR EACH ROW
            BEGIN

                DECLARE v_admin INT;
                SELECT admin_id INTO v_admin
                FROM invoices
                WHERE id = NEW.invoice_id;

                SET NEW.seq_id = (SELECT f_gen_seq('payments',v_admin));
            END
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_payments_bi_seq');
    }
}
