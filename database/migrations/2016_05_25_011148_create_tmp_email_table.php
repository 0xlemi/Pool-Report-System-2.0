<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmpEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_emails', function (Blueprint $table) {
            $table->string('email')->primary();
        });

        DB::unprepared("
        INSERT INTO tmp_emails
          SELECT email FROM clients
          UNION ALL
          SELECT email FROM users
          UNION ALL
          SELECT email FROM supervisors;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tmp_emails');
    }
}
