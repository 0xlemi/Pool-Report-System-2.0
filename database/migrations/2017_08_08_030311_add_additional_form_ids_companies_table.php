<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalFormIdsCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('report_form_id')->nullable();
            $table->string('report_destination_id')->nullable();
            $table->string('work_order_form_id')->nullable();
            $table->string('work_order_destination_id')->nullable();
            $table->string('work_form_id')->nullable();
            $table->string('work_destination_id')->nullable();

            $table->dropColumn('form_id');
            $table->dropColumn('destination_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('work_order_form_id');
            $table->dropColumn('work_order_destination_id');
            $table->dropColumn('work_form_id');
            $table->dropColumn('work_destination_id');
        });
    }
}
