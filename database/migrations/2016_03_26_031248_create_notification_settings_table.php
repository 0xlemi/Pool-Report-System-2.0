<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id')->unsigned();
            $table->string('name');
            $table->string('text');

            $table->primary('id');
            $table->timestamps();
        });

        DB::table('notification_settings')->insert([
            [ 'id' => 1, 'name' => 'notify_report_created_database', 'text' => 'Notification when Report is Created', ],
            [ 'id' => 2, 'name' => 'notify_workorder_created_database', 'text' => 'Notification when Work Order is Created', ],
            [ 'id' => 3, 'name' => 'notify_service_created_database', 'text' => 'Notification when Service is Created', ],
            [ 'id' => 4, 'name' => 'notify_client_created_database', 'text' => 'Notification when Client is Created', ],
            [ 'id' => 5, 'name' => 'notify_supervisor_created_database', 'text' => 'Notification when Supervisor is Created', ],
            [ 'id' => 6, 'name' => 'notify_technician_created_database', 'text' => 'Notification when Technician is Created', ],
            [ 'id' => 7, 'name' => 'notify_invoice_created_database', 'text' => 'Notification when Invoice is Created', ],
            [ 'id' => 8, 'name' => 'notify_payment_created_database', 'text' => 'Notification when Payment is Created', ],
            [ 'id' => 9, 'name' => 'notify_work_added_database', 'text' => 'Notification when Work is added to Work Order', ],
            [ 'id' => 10, 'name' => 'notify_chemical_added_database', 'text' => 'Notification when Chemical is added to Service', ],
            [ 'id' => 11, 'name' => 'notify_equipment_added_database', 'text' => 'Notification when Equipment is added to Service', ],
            [ 'id' => 12, 'name' => 'notify_contract_added_database', 'text' => 'Notification when Contract is added to Service', ],

            [ 'id' => 13, 'name' => 'notify_report_created_mail', 'text' => 'Email when Report is Created', ],
            [ 'id' => 14, 'name' => 'notify_workorder_created_mail', 'text' => 'Email when Work Order is Created', ],
            [ 'id' => 15, 'name' => 'notify_service_created_mail', 'text' => 'Email when Service is Created', ],
            [ 'id' => 16, 'name' => 'notify_client_created_mail', 'text' => 'Email when Client is Created', ],
            [ 'id' => 17, 'name' => 'notify_supervisor_created_mail', 'text' => 'Email when Supervisor is Created', ],
            [ 'id' => 18, 'name' => 'notify_technician_created_mail', 'text' => 'Email when Technician is Created', ],
            [ 'id' => 19, 'name' => 'notify_invoice_created_mail', 'text' => 'Email when Invoice is Created', ],
            [ 'id' => 20, 'name' => 'notify_payment_created_mail', 'text' => 'Email when Payment is Created', ],
            // [ 'id' => num,'name' => 'notify_work_added_mail', 'text' => 'Email when Work is added to Work Order', ],
            // [ 'id' => num,'name' => 'notify_chemical_added_mail', 'text' => 'Email when Chemical is added to Service', ],
            // [ 'id' => num,'name' => 'notify_equipment_added_mail', 'text' => 'Email when Equipment is added to Service', ],
            // [ 'id' => num,'name' => 'notify_contract_added_mail', 'text' => 'Email when Contract is added to Service', ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_settings');
    }
}
