<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersUserRoleCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER trg_user_role_company_bi_seq
            BEFORE INSERT ON user_role_company
            FOR EACH ROW
            BEGIN
              SET NEW.seq_id = (SELECT f_gen_seq('user_role_company',NEW.company_id));
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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_user_role_company_bi_seq');
    }
}
