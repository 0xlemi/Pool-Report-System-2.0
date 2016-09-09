<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersWorkOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER trg_work_orders_bi_seq
            BEFORE INSERT ON work_orders
            FOR EACH ROW
            BEGIN
                DECLARE v_admin1 INT;
                DECLARE v_admin2 INT;
                DECLARE msg VARCHAR(255);

                SELECT admin_id INTO v_admin1
                FROM services
                WHERE id = NEW.service_id;

                SELECT admin_id INTO v_admin2
                FROM supervisors
                WHERE id = NEW.supervisor_id;

                IF v_admin1 <> v_admin2 THEN
                SET msg = CONCAT('WORKORDERUSERERROR: SERVICE AND SUPERVISOR HAS INCONSISTENT ADMIN');
                SIGNAL SQLSTATE '99993' SET MESSAGE_TEXT = msg;
                ELSE
                    SET NEW.seq_id = (SELECT f_gen_seq('work_orders', v_admin1));
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_work_orders_bi_seq');
    }
}
