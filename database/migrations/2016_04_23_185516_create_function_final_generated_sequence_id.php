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
            CREATE FUNCTION f_gen_seq(p_seq_name VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci, p_user_id INT) RETURNS INT
            BEGIN
             UPDATE seq
             SET val = last_insert_id(val+1) 
             WHERE `name` = p_seq_name AND
                   `user_id` = p_user_id;
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
