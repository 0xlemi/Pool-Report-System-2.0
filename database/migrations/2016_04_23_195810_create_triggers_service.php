<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER trg_services_bi_seq
            BEFORE INSERT ON services
            FOR EACH ROW
            BEGIN
              SET NEW.seq_id = (SELECT f_gen_seq('services',NEW.company_id));
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_services_bi_seq');
    }
}
