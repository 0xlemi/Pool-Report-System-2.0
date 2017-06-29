<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersGlobalProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION p_global_products_bi_seq() RETURNS TRIGGER
                AS $BODY$
                BEGIN
                    NEW.seq_id := (SELECT f_gen_seq(\'global_products\',NEW.company_id));

                    RETURN NEW;
                END; $BODY$ LANGUAGE plpgsql;

            CREATE TRIGGER trg_global_products_bi_seq
                BEFORE INSERT ON global_products
                FOR EACH ROW
                EXECUTE PROCEDURE p_global_products_bi_seq();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_global_products_bi_seq ON global_products;');
    }
}
