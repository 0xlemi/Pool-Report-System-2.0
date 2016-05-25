<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllEmailsPasswordsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::unprepared("
        CREATE VIEW v_passwords
        AS
          SELECT email, password, 'user' as object_type, id
          FROM users
          UNION ALL
          SELECT email, password, 'client' as object_type, id
          FROM clients
          UNION ALL
          SELECT email, password, 'supervisor' as object_type, id
          FROM supervisors
          UNION ALL
          SELECT username, password, 'technician' as object_type, id
          FROM technicians;
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      DB::unprepared('DROP VIEW IF EXISTS v_passwords');
    }
}
