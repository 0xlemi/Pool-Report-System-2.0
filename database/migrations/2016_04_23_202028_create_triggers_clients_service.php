<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersClientsService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER trg_client_service_bi_email_unique
            BEFORE INSERT ON client_service
            FOR EACH ROW
            BEGIN
              DECLARE v_email VARCHAR(255);
              DECLARE res INT;
              DECLARE msg VARCHAR(255);
              
              
              SELECT DISTINCT email INTO v_email
              FROM clients
              WHERE id = NEW.client_id;

              SELECT IsEmailUniqueCheck(v_email, NEW.client_id) INTO res;
              IF res > 0 THEN
                set msg = concat('ClientEmailError: Trying to insert duplicite email: ', v_email);
                    signal sqlstate '99999' set message_text = msg;
              END IF;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_client_service_bu_email_unique
            BEFORE UPDATE ON client_service
            FOR EACH ROW
            BEGIN
              DECLARE v_email VARCHAR(255);
              DECLARE res INT;
              DECLARE msg VARCHAR(255);
              
              SELECT DISTINCT email INTO v_email
              FROM clients
              WHERE id = NEW.client_id;

              SELECT IsEmailUniqueCheck(v_email, NEW.client_id) INTO res;
              IF res > 0 THEN
                set msg = concat('ClientEmailError: Trying to insert duplicite email: ', v_email);
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_client_service_bi_email_unique');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_client_service_bu_email_unique');
    }
}
