<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersGlobalChemical extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER trg_global_chemicals_bi_seq
            BEFORE INSERT ON global_chemicals
            FOR EACH ROW
            BEGIN
              SET NEW.seq_id = (SELECT f_gen_seq('global_chemicals',NEW.company_id));
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_global_chemicals_bi_seq');
    }
}
