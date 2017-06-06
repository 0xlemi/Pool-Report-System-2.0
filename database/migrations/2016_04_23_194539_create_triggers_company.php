<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION p_company_ai_seq() RETURNS TRIGGER
                AS $BODY$
                BEGIN
                    INSERT INTO "seq" ("name", "company_id", "val")
                    VALUES (\'user_role_company\', NEW.id, 0);
                    INSERT INTO "seq" ("name", "company_id", "val")
                    VALUES (\'services\', NEW.id, 0);
                    INSERT INTO "seq" ("name", "company_id", "val")
                    VALUES (\'reports\', NEW.id, 10000);
                    INSERT INTO "seq" ("name", "company_id", "val")
                    VALUES (\'work_orders\', NEW.id, 10000);
                    INSERT INTO "seq" ("name", "company_id", "val")
                    VALUES (\'invoices\', NEW.id, 10000);
                    INSERT INTO "seq" ("name", "company_id", "val")
                    VALUES (\'payments\', NEW.id, 10000);
                    INSERT INTO "seq" ("name", "company_id", "val")
                    VALUES (\'global_measurements\', NEW.id, 0);
                    INSERT INTO "seq" ("name", "company_id", "val")
                    VALUES (\'global_products\', NEW.id, 0);

                    RETURN NEW;
                END; $BODY$ LANGUAGE plpgsql;

            CREATE TRIGGER trg_company_ai_seq
                AFTER INSERT ON companies
                FOR EACH ROW
                EXECUTE PROCEDURE p_company_ai_seq();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_company_ai_seq ON companies');
        // DB::unprepared('DROP FUNCTION IF EXISTS p_company_ai_seq();');
    }
}
