<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Service;
use Stripe\Error\ApiConnection;

class CreateClientServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_service', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('user_id')->unsigned()->index();
            $table->integer('service_id')->unsigned()->index();

            $table->timestamps();

            $table->primary(['user_id', 'service_id']);

            // ************************************
            //  REALLY IMPORTANT TO CHECK THAT THIS
            //  USER HAS ROLE OF CLIENT IN THE
            //  SERVICE COMPANY BEFORE CONNECTION
            //  ***********************************

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');

        });

        // DB::unprepared("
        //     ALTER TABLE `client_service`
        //         ADD CHECK (invoiceable_type IN (
        //             'App\WorkOrder',
        //             'App\ServiceContract'
        //         ));
        // ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('client_service');
    }
}
