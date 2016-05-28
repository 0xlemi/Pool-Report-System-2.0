<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersSupervisor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::unprepared("
        CREATE TRIGGER trg_supervisors_bi_seq
        BEFORE INSERT ON supervisors
        FOR EACH ROW
        BEGIN
            SET NEW.seq_id = (SELECT f_gen_seq('supervisors',NEW.admin_id));
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_supervisors_bi_seq');
    }
}
