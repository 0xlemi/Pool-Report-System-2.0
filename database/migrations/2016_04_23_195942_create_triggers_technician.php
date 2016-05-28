<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersTechnician extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE TRIGGER trg_technicians_bi_seq
        BEFORE INSERT ON technicians
        FOR EACH ROW
        BEGIN
            DECLARE v_admin INT;
            SELECT admin_id INTO v_admin
            FROM supervisors
            WHERE id = NEW.supervisor_id;
            SET NEW.seq_id = (SELECT f_gen_seq('technicians',v_admin));
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_technicians_bi_seq');
    }
}
