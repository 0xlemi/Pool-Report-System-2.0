<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION p_invoices_bi_seq() RETURNS TRIGGER
                AS $BODY$
                BEGIN
                    NEW.seq_id := (SELECT f_gen_seq(\'invoices\',NEW.company_id));

                    RETURN NEW;
                END; $BODY$ LANGUAGE plpgsql;

            CREATE TRIGGER trg_invoices_bi_seq
                BEFORE INSERT ON invoices
                FOR EACH ROW
                EXECUTE PROCEDURE p_invoices_bi_seq();
      ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_invoices_bi_seq ON invoices;');
    }
}
