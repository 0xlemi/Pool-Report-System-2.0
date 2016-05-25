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
          CREATE TRIGGER trg_users_ad_email
          AFTER DELETE ON users
          FOR EACH ROW
          BEGIN
            DELETE FROM tmp_emails
            WHERE email = OLD.email;
          END
        ");

        DB::unprepared("
          CREATE TRIGGER trg_users_bi_email
          BEFORE INSERT ON users
          FOR EACH ROW
          BEGIN
            INSERT INTO tmp_emails
            VALUES (NEW.email);
          END
        ");

        DB::unprepared("
          CREATE TRIGGER trg_users_bu_email
          BEFORE UPDATE ON users
          FOR EACH ROW
          BEGIN
            DELETE FROM tmp_emails
            WHERE email = OLD.email;
            INSERT INTO tmp_emails
            VALUES (NEW.email);
          END
        ");

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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_users_ad_email');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_users_bi_email');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_users_bu_email');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_users_ai_seq');
    }
}
