<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersAdministrator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER trg_administrators_ai_seq
            AFTER INSERT ON administrators
            FOR EACH ROW
            BEGIN
                INSERT INTO `seq` (`name`, `admin_id`, `val`)
                VALUES ('clients', NEW.id, 0);
                INSERT INTO `seq` (`name`, `admin_id`, `val`)
                VALUES ('services', NEW.id, 0);
                INSERT INTO `seq` (`name`, `admin_id`, `val`)
                VALUES ('reports', NEW.id, 0);
                INSERT INTO `seq` (`name`, `admin_id`, `val`)
                VALUES ('work_orders', NEW.id, 0);
                INSERT INTO `seq` (`name`, `admin_id`, `val`)
                VALUES ('supervisors', NEW.id, 0);
                INSERT INTO `seq` (`name`, `admin_id`, `val`)
                VALUES ('technicians', NEW.id, 0);
                INSERT INTO `seq` (`name`, `admin_id`, `val`)
                VALUES ('invoices', NEW.id, 10000);
                INSERT INTO `seq` (`name`, `admin_id`, `val`)
                VALUES ('payments', NEW.id, 10000);
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_administrators_ai_seq');
    }
}
