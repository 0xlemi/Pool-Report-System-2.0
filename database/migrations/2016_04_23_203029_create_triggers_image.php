<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER trg_images_bi_source
            BEFORE INSERT ON images
            FOR EACH ROW
            BEGIN
              DECLARE msg VARCHAR(255);
              IF CASE
                   WHEN NEW.technician_id IS NULL THEN 0 
                   ELSE 1
                 END + 
                 CASE
                   WHEN NEW.supervisor_id IS NULL THEN 0 
                   ELSE 1
                 END +
                 CASE
                   WHEN NEW.client_id IS NULL THEN 0 
                   ELSE 1
                 END +
                 CASE
                   WHEN NEW.service_id IS NULL THEN 0 
                   ELSE 1
                 END +
                 CASE
                   WHEN NEW.report_id IS NULL THEN 0 
                   ELSE 1
                 END <> 1 THEN
                set msg = concat('ImageSourceError: Just one Client/Technician/Supervisor/Service/Report must be filled');
                    signal sqlstate '99997' set message_text = msg;
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_images_bi_source');
    }
}
