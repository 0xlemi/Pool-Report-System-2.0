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
        DB::unprepared('
            CREATE OR REPLACE FUNCTION p_user_role_company_bi_seq() RETURNS TRIGGER
                AS $BODY$
                BEGIN
                    NEW.seq_id := (SELECT f_gen_seq(\'user_role_company\',NEW.company_id));

                    RETURN NEW;
                END; $BODY$ LANGUAGE plpgsql;

            CREATE TRIGGER trg_user_role_company_bi_seq
                BEFORE INSERT ON user_role_company
                FOR EACH ROW
                EXECUTE PROCEDURE p_user_role_company_bi_seq();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_user_role_company_bi_seq ON user_role_company;');
    }
}
