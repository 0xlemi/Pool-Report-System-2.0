<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFunctionFinalGeneratedSequenceId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION f_gen_seq(p_seq_name VARCHAR(50), p_company_id INT) RETURNS BIGINT
            AS $$
            DECLARE v_val BIGINT;
            BEGIN
                UPDATE seq
                SET val = val+1
                WHERE "name" = p_seq_name AND
                "company_id" = p_company_id
                RETURNING val INTO v_val;

            RETURN v_val;
            END; $$LANGUAGE plpgsql;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS f_gen_seq(VARCHAR(50),INT)');
    }
}
