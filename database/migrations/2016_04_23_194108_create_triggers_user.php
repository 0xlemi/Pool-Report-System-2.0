<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::unprepared("
        //     CREATE TRIGGER trg_users_bi_seq
        //     BEFORE INSERT ON users
        //     FOR EACH ROW
        //     BEGIN
        //       SET NEW.seq_id = (SELECT f_gen_seq('users',NEW.company_id));
        //     END
        // ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
