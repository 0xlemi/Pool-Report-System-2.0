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
            CREATE TRIGGER trg_clients_bi_email_unique_and_seq
            BEFORE INSERT ON clients
            FOR EACH ROW
            BEGIN
              DECLARE res INT;
              DECLARE msg VARCHAR(255);
              SELECT IsEmailUniqueCheck(NEW.email, NEW.id) INTO res;
              IF res > 0 THEN
                set msg = concat('ClientEmailError: Trying to insert duplicite email: ', NEW.email);
                    signal sqlstate '99999' set message_text = msg;
              ELSE
                SET NEW.seq_id = (SELECT f_gen_seq('clients',NEW.user_id));
              END IF;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_clients_bu_email_unique
            BEFORE UPDATE ON clients
            FOR EACH ROW
            BEGIN
              DECLARE res INT;
              DECLARE msg VARCHAR(255);
              SELECT IsEmailUniqueCheck(NEW.email, NEW.id) INTO res;
              IF res > 0 THEN
                set msg = concat('ClientEmailError: Trying to insert duplicite email: ', NEW.email);
                    signal sqlstate '99999' set message_text = msg;
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_clients_bi_email_unique_and_seq');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_clients_bu_email_unique');
    }
}
