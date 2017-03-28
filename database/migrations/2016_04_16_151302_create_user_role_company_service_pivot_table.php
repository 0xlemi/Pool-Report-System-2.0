<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRoleCompanyServicePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urc_service', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('urc_id')->unsigned()->index();
            $table->integer('service_id')->unsigned()->index();

            $table->timestamps();

            $table->primary(['urc_id', 'service_id']);

            // ************************************
            //  REALLY IMPORTANT TO CHECK THAT THIS
            //  USER HAS ROLE OF CLIENT IN THE
            //  SERVICE COMPANY BEFORE CONNECTION
            //  ***********************************

            $table->foreign('urc_id')
                ->references('id')
                ->on('user_role_company')
                ->onDelete('cascade');
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urc_service');
    }
}
