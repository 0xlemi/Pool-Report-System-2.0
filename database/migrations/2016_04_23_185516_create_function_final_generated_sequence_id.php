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
        CREATE FUNCTION f_gen_seq(p_seq_name VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci, p_admin_id INT) RETURNS int(11)
        BEGIN
            UPDATE seq
            SET val = last_insert_id(val+1)
            WHERE `name` = p_seq_name AND
                `admin_id` = p_admin_id;
            RETURN last_insert_id();
        END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS f_gen_seq');
    }
}
