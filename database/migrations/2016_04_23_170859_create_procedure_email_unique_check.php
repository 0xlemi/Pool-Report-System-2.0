<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedureEmailUniqueCheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE FUNCTION IsEmailUniqueCheck (p_email VARCHAR(255) CHARSET utf8 COLLATE utf8_unicode_ci, p_client_id INT)
            RETURNS INT
            BEGIN
              DECLARE v_user_id INT;
              DECLARE v_cnt INT;
              
              SELECT user_id INTO v_user_id
              FROM clients
              WHERE id = p_client_id;

              SELECT COUNT(*) INTO v_cnt 
              FROM clients C1 
              WHERE C1.id <> p_client_id AND
                    C1.email = p_email AND
                    C1.user_id = v_user_id;
              RETURN v_cnt;
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
        DB::unprepared('DROP FUNCTION IF EXISTS IsEmailUniqueCheck');
    }
}
