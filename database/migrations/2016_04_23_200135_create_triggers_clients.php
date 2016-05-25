<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::unprepared("
        CREATE TRIGGER trg_clients_ad_email
        AFTER DELETE ON clients
        FOR EACH ROW
        BEGIN
          DELETE FROM tmp_emails
          WHERE email = OLD.email;
        END
      ");

      DB::unprepared("
        CREATE TRIGGER trg_clients_bi_seq_and_email
        BEFORE INSERT ON clients
        FOR EACH ROW
        BEGIN
          INSERT INTO tmp_emails
          VALUES (NEW.email);
          SET NEW.seq_id = (SELECT f_gen_seq('clients',NEW.user_id));
        END
      ");

      DB::unprepared("
        CREATE TRIGGER trg_clients_bu_email
        BEFORE UPDATE ON clients
        FOR EACH ROW
        BEGIN
          DELETE FROM tmp_emails
          WHERE email = OLD.email;
          INSERT INTO tmp_emails
          VALUES (NEW.email);
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
      DB::unprepared('DROP TRIGGER IF EXISTS trg_clients_ad_email');
      DB::unprepared('DROP TRIGGER IF EXISTS trg_clients_bi_seq_and_email');
      DB::unprepared('DROP TRIGGER IF EXISTS trg_clients_bu_email');
    }
}
