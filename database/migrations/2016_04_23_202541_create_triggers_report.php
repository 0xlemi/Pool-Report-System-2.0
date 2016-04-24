<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER trg_reports_bi_user_consistency_and_seq
            BEFORE INSERT ON reports
            FOR EACH ROW
            BEGIN
              DECLARE v_user1 INT;
              DECLARE v_user2 INT;
              DECLARE msg VARCHAR(255);
              
              SELECT user_id INTO v_user1
              FROM services
              WHERE id = NEW.service_id;

              SELECT user_id INTO v_user2
              FROM technicians T, supervisors S
              WHERE T.id = NEW.technician_id AND
                    S.id = T.supervisor_id;

              IF v_user1 <> v_user2 THEN
                set msg = concat('ReportUserError: Technician and Service has inconsistent user');
                    signal sqlstate '99993' set message_text = msg;
              ELSE
                SET NEW.seq_id = (SELECT f_gen_seq('reports',v_user1));
              END IF;
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_reports_bi_user_consistency_and_seq');
    }
}
