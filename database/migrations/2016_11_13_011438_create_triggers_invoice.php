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
        DB::unprepared("
            CREATE TRIGGER trg_invoices_bi_seq
            BEFORE INSERT ON invoices
            FOR EACH ROW
                BEGIN
                SET NEW.seq_id = (SELECT f_gen_seq('invoices',NEW.admin_id));
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_invoices_bi_seq');
    }
}
