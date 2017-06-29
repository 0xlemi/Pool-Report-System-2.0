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
        DB::unprepared('
            CREATE OR REPLACE FUNCTION p_payments_bi_seq() RETURNS TRIGGER
                AS $$
                  DECLARE v_company_id INT;
                BEGIN
                    SELECT company_id INTO v_company_id
                    FROM invoices
                    WHERE id = NEW.invoice_id;

                    NEW.seq_id := (SELECT f_gen_seq(\'payments\',v_company_id));

                    RETURN NEW;
                END; $$ LANGUAGE plpgsql;

            CREATE TRIGGER trg_payments_bi_seq
                BEFORE INSERT ON payments
                FOR EACH ROW
                EXECUTE PROCEDURE p_payments_bi_seq();
      ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_payments_bi_seq on payments;');
    }
}
