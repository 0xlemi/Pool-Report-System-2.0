<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER trg_users_ai_seq
            AFTER INSERT ON users
            FOR EACH ROW
            BEGIN
              INSERT INTO `seq` (`name`, `user_id`, `val`)
              VALUES ('clients', NEW.id, 0);
              INSERT INTO `seq` (`name`, `user_id`, `val`)
              VALUES ('services', NEW.id, 0);
              INSERT INTO `seq` (`name`, `user_id`, `val`)
              VALUES ('reports', NEW.id, 0);
              INSERT INTO `seq` (`name`, `user_id`, `val`)
              VALUES ('supervisors', NEW.id, 0);
              INSERT INTO `seq` (`name`, `user_id`, `val`)
              VALUES ('technicians', NEW.id, 0);
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_users_ai_seq');
    }
}
