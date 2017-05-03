<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersGlobalMeasurement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER trg_global_measurements_bi_seq
            BEFORE INSERT ON global_measurements
            FOR EACH ROW
            BEGIN
              SET NEW.seq_id = (SELECT f_gen_seq('global_measurements',NEW.company_id));
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_global_measurements_bi_seq');
    }
}
