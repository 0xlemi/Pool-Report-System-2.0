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
          CREATE TRIGGER trg_supervisors_ad_email
          AFTER DELETE ON supervisors
          FOR EACH ROW
          BEGIN
            DELETE FROM tmp_emails
            WHERE email = OLD.email;
          END
        ");

        DB::unprepared("
        CREATE TRIGGER trg_supervisors_bu_email
        BEFORE UPDATE ON supervisors
        FOR EACH ROW
        BEGIN
          DELETE FROM tmp_emails
          WHERE email = OLD.email;
          INSERT INTO tmp_emails
          VALUES (NEW.email);
        END
        ");

        DB::unprepared("
        CREATE TRIGGER trg_supervisors_bi_email_and_seq
        BEFORE INSERT ON supervisors
        FOR EACH ROW
        BEGIN
          INSERT INTO tmp_emails
          VALUES (NEW.email);
          SET NEW.seq_id = (SELECT f_gen_seq('supervisors',NEW.user_id));
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_supervisors_ad_email');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_supervisors_bu_email');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_supervisors_bi_email_and_seq');
    }
}
