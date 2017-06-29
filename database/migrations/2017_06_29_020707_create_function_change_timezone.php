<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFunctionChangeTimezone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION convert_tz(dt timestamp, from_tz text, to_tz text)
                RETURNS timestamp AS $$
                SELECT ($1 AT TIME ZONE $2) AT TIME ZONE $3;
                $$ LANGUAGE sql;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS convert_tz(timestamp, text, text)');
    }
}
