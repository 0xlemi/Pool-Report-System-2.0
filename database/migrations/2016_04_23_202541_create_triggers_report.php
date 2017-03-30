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
        // DB::unprepared("
        // CREATE TRIGGER trg_reports_bi_admin_consistency_and_seq
        // BEFORE INSERT ON reports
        // FOR EACH ROW
        // BEGIN
        //     DECLARE v_admin1 INT;
        //     DECLARE v_admin2 INT;
        //     DECLARE msg VARCHAR(255);
        //
        //     SELECT admin_id INTO v_admin1
        //     FROM services
        //     WHERE id = NEW.service_id;
        //
        //     SELECT admin_id INTO v_admin2
        //     FROM technicians T, supervisors S
        //     WHERE T.id = NEW.technician_id AND
        //         S.id = T.supervisor_id;
        //
        //     IF v_admin1 <> v_admin2 THEN
        //     SET msg = CONCAT('REPORTUSERERROR: TECHNICIAN AND SERVICE HAS INCONSISTENT ADMIN');
        //     SIGNAL SQLSTATE '99993' SET MESSAGE_TEXT = msg;
        //     ELSE
        //     SET NEW.seq_id = (SELECT f_gen_seq('reports',v_admin1));
        //     END IF;
        // END
        // ");
        DB::unprepared("
            CREATE TRIGGER trg_reports_bi_seq
                BEFORE INSERT ON reports
                FOR EACH ROW
                BEGIN

                DECLARE v_company_id INT;
                SELECT company_id INTO v_company_id
                FROM services
                WHERE id = NEW.service_id;

                SET NEW.seq_id = (SELECT f_gen_seq('reports',v_company_id));
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
        // DB::unprepared('DROP TRIGGER IF EXISTS trg_reports_bi_admin_consistency_and_seq');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_reports_bi_seq');
    }
}
