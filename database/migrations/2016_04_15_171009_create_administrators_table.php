<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->increments('id');
            // General Settings
                // Administrator Profile information
                $table->string('name');
            // Company information
                $table->string('company_name');
                $table->string('timezone');
                $table->char('language', 2)->default('en');
                $table->string('website')->nullable();
                $table->string('facebook')->nullable();
                $table->string('twitter')->nullable();
            // System Values
                // ph
                $table->string('ph_very_low')->default('Very Low'); // 1
                $table->string('ph_low')->default('Low'); // 2
                $table->string('ph_perfect')->default('Perfect'); // 3
                $table->string('ph_high')->default('High'); // 4
                $table->string('ph_very_high')->default('Very High'); // 5
                // chlorine
                $table->string('chlorine_very_low')->default('Very Low'); // 1
                $table->string('chlorine_low')->default('Low'); // 2
                $table->string('chlorine_perfect')->default('Perfect'); // 3
                $table->string('chlorine_high')->default('High'); // 4
                $table->string('chlorine_very_high')->default('Very High'); // 5
                // temperature
                $table->string('temperature_very_low')->default('Very Low'); // 1
                $table->string('temperature_low')->default('Low'); // 2
                $table->string('temperature_perfect')->default('Perfect'); // 3
                $table->string('temperature_high')->default('High'); // 4
                $table->string('temperature_very_high')->default('Very High'); // 5
                // turbidity
                $table->string('turbidity_perfect')->default('Perfect'); // 1
                $table->string('turbidity_low')->default('Low'); // 2
                $table->string('turbidity_high')->default('High'); // 3
                $table->string('turbidity_very_high')->default('Very High'); // 4
                // salt
                $table->string('salt_very_low')->default('Very Low'); // 1
                $table->string('salt_low')->default('Low'); // 2
                $table->string('salt_perfect')->default('Perfect'); // 3
                $table->string('salt_high')->default('High'); // 4
                $table->string('salt_very_high')->default('Very High'); // 5
            // Billing
                $table->integer('free_objects')->default(3);
                // Stripe
                $table->string('stripe_id')->nullable();
                $table->string('card_brand')->nullable();
                $table->string('card_last_four')->nullable();
                $table->timestamp('trial_ends_at')->nullable();
            // Permissions

                // Report
                $table->boolean('sup_report_view')->default(1);
                $table->boolean('sup_report_create')->default(1);
                $table->boolean('sup_report_update')->default(1);
                $table->boolean('sup_report_addPhoto')->default(1);
                $table->boolean('sup_report_removePhoto')->default(1);
                $table->boolean('sup_report_delete')->default(1);

                $table->boolean('tech_report_view')->default(1);
                $table->boolean('tech_report_create')->default(1);
                $table->boolean('tech_report_update')->default(0);
                $table->boolean('tech_report_addPhoto')->default(0);
                $table->boolean('tech_report_removePhoto')->default(0);
                $table->boolean('tech_report_delete')->default(0);

                // Work Orders
                $table->boolean('sup_workorder_view')->default(1);
                $table->boolean('sup_workorder_create')->default(1);
                $table->boolean('sup_workorder_update')->default(1);
                $table->boolean('sup_workorder_finish')->default(1);
                $table->boolean('sup_workorder_addPhoto')->default(1);
                $table->boolean('sup_workorder_removePhoto')->default(1);
                $table->boolean('sup_workorder_delete')->default(1);

                $table->boolean('tech_workorder_view')->default(1);
                $table->boolean('tech_workorder_create')->default(1);
                $table->boolean('tech_workorder_update')->default(0);
                $table->boolean('tech_workorder_finish')->default(1);
                $table->boolean('tech_workorder_addPhoto')->default(0);
                $table->boolean('tech_workorder_removePhoto')->default(0);

                    // Works
                    $table->boolean('sup_work_view')->default(1);
                    $table->boolean('sup_work_create')->default(1);
                    $table->boolean('sup_work_update')->default(1);
                    $table->boolean('sup_work_addPhoto')->default(1);
                    $table->boolean('sup_work_removePhoto')->default(1);
                    $table->boolean('sup_work_delete')->default(1);

                    $table->boolean('tech_work_view')->default(1);
                    $table->boolean('tech_work_create')->default(1);
                    $table->boolean('tech_work_update')->default(0);
                    $table->boolean('tech_work_addPhoto')->default(1);
                    $table->boolean('tech_work_removePhoto')->default(0);
                    $table->boolean('tech_work_delete')->default(0);

                // Services
                $table->boolean('sup_service_view')->default(1);
                $table->boolean('sup_service_create')->default(1);
                $table->boolean('sup_service_update')->default(1);
                $table->boolean('sup_service_delete')->default(1);

                $table->boolean('tech_service_view')->default(1);
                $table->boolean('tech_service_create')->default(0);
                $table->boolean('tech_service_update')->default(0);

                    // Contract
                    $table->boolean('sup_contract_view')->default(1);
                    $table->boolean('sup_contract_create')->default(1);
                    $table->boolean('sup_contract_update')->default(1);
                    $table->boolean('sup_contract_deactivate')->default(1);
                    $table->boolean('sup_contract_delete')->default(1);

                    $table->boolean('tech_contract_view')->default(0);
                    $table->boolean('tech_contract_create')->default(0);
                    $table->boolean('tech_contract_update')->default(0);
                    $table->boolean('tech_contract_deactivate')->default(0);
                    $table->boolean('tech_contract_delete')->default(0);

                    // Chemicals
                    $table->boolean('sup_chemical_view')->default(1);
                    $table->boolean('sup_chemical_create')->default(1);
                    $table->boolean('sup_chemical_update')->default(1);
                    $table->boolean('sup_chemical_delete')->default(1);

                    $table->boolean('tech_chemical_view')->default(1);
                    $table->boolean('tech_chemical_create')->default(1);
                    $table->boolean('tech_chemical_update')->default(0);
                    $table->boolean('tech_chemical_delete')->default(0);

                    // Equipment
                    $table->boolean('sup_equipment_view')->default(1);
                    $table->boolean('sup_equipment_create')->default(1);
                    $table->boolean('sup_equipment_update')->default(1);
                    $table->boolean('sup_equipment_addPhoto')->default(1);
                    $table->boolean('sup_equipment_removePhoto')->default(1);
                    $table->boolean('sup_equipment_delete')->default(1);

                    $table->boolean('tech_equipment_view')->default(1);
                    $table->boolean('tech_equipment_create')->default(1);
                    $table->boolean('tech_equipment_update')->default(0);
                    $table->boolean('tech_equipment_addPhoto')->default(1);
                    $table->boolean('tech_equipment_removePhoto')->default(0);
                    $table->boolean('tech_equipment_delete')->default(0);

                // Client
                $table->boolean('sup_client_view')->default(1);
                $table->boolean('sup_client_create')->default(1);
                $table->boolean('sup_client_update')->default(1);
                $table->boolean('sup_client_delete')->default(1);

                $table->boolean('tech_client_view')->default(0);

                // Supervisors
                $table->boolean('sup_supervisor_view')->default(1);
                $table->boolean('sup_supervisor_create')->default(1);
                $table->boolean('sup_supervisor_update')->default(0);
                $table->boolean('sup_supervisor_delete')->default(0);

                $table->boolean('tech_supervisor_view')->default(0);

                // Technicians
                $table->boolean('sup_technician_view')->default(1);
                $table->boolean('sup_technician_create')->default(1);
                $table->boolean('sup_technician_update')->default(1);
                $table->boolean('sup_technician_delete')->default(1);

                $table->boolean('tech_technician_view')->default(0);

                // Invoices
                $table->boolean('sup_invoice_view')->default(1);
                $table->boolean('sup_invoice_delete')->default(0);

                $table->boolean('tech_invoice_view')->default(0);

                    // payments
                    $table->boolean('sup_payment_view')->default(1);
                    $table->boolean('sup_payment_create')->default(1);
                    $table->boolean('sup_payment_delete')->default(0);

                    $table->boolean('tech_payment_view')->default(0);
                    $table->boolean('tech_payment_create')->default(0);


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('administrators');
    }
}
