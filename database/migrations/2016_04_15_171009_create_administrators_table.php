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
                $table->char('language', 2)->default('en');
                $table->string('timezone');
                // Administrator Profile information
                $table->string('name');
            // Company information
                $table->string('company_name');
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
            // Email Preferences
                $table->boolean('get_reports_emails')->default(0);
            // Billing
                $table->integer('free_objects')->default(3);
                // Stripe
                $table->string('stripe_id')->nullable();
                $table->string('card_brand')->nullable();
                $table->string('card_last_four')->nullable();
                $table->timestamp('trial_ends_at')->nullable();
            // Permissions

                // Report
                $table->boolean('sup_report_index')->default(1);
                $table->boolean('sup_report_create')->default(1);
                $table->boolean('sup_report_show')->default(1);
                $table->boolean('sup_report_edit')->default(1);
                $table->boolean('sup_report_addPhoto')->default(1);
                $table->boolean('sup_report_removePhoto')->default(1);
                $table->boolean('sup_report_destroy')->default(1);

                $table->boolean('tech_report_index')->default(1);
                $table->boolean('tech_report_create')->default(1);
                $table->boolean('tech_report_show')->default(1);
                $table->boolean('tech_report_edit')->default(0);
                $table->boolean('tech_report_addPhoto')->default(0);
                $table->boolean('tech_report_removePhoto')->default(0);
                $table->boolean('tech_report_destroy')->default(0);

                // Work Orders
                $table->boolean('sup_workorder_index')->default(1);
                $table->boolean('sup_workorder_create')->default(1);
                $table->boolean('sup_workorder_show')->default(1);
                $table->boolean('sup_workorder_edit')->default(1);
                $table->boolean('sup_workorder_finish')->default(1);
                $table->boolean('tech_workorder_addPhoto')->default(1);
                $table->boolean('tech_workorder_removePhoto')->default(1);
                $table->boolean('sup_workorder_destroy')->default(1);

                $table->boolean('tech_workorder_index')->default(1);
                $table->boolean('tech_workorder_create')->default(1);
                $table->boolean('tech_workorder_show')->default(1);
                $table->boolean('tech_workorder_edit')->default(0);
                $table->boolean('tech_workorder_finish')->default(1);
                $table->boolean('tech_workorder_addPhoto')->default(0);
                $table->boolean('tech_workorder_removePhoto')->default(0);
                    // Works
                    $table->boolean('sup_work_index')->default(1);
                    $table->boolean('sup_work_create')->default(1);
                    $table->boolean('sup_work_show')->default(1);
                    $table->boolean('sup_work_edit')->default(1);
                    $table->boolean('sup_work_addPhoto')->default(1);
                    $table->boolean('sup_work_removePhoto')->default(1);
                    $table->boolean('sup_work_destroy')->default(1);

                    $table->boolean('tech_work_index')->default(1);
                    $table->boolean('tech_work_create')->default(1);
                    $table->boolean('tech_work_show')->default(1);
                    $table->boolean('tech_work_edit')->default(0);
                    $table->boolean('tech_work_addPhoto')->default(1);
                    $table->boolean('tech_work_removePhoto')->default(0);
                    $table->boolean('tech_work_destroy')->default(0);

                // Services
                $table->boolean('sup_service_index')->default(1);
                $table->boolean('sup_service_create')->default(1);
                $table->boolean('sup_service_show')->default(1);
                $table->boolean('sup_service_edit')->default(1);
                $table->boolean('sup_service_destroy')->default(1);

                $table->boolean('tech_service_index')->default(1);
                $table->boolean('tech_service_create')->default(0);
                $table->boolean('tech_service_show')->default(1);
                $table->boolean('tech_service_edit')->default(0);
                    // Contract
                    $table->boolean('sup_contract_create')->default(1);
                    $table->boolean('sup_contract_show')->default(1);
                    $table->boolean('sup_contract_edit')->default(1);
                    $table->boolean('sup_contract_deactivate')->default(1);
                    $table->boolean('sup_contract_destroy')->default(1);

                    $table->boolean('tech_contract_create')->default(0);
                    $table->boolean('tech_contract_show')->default(0);
                    $table->boolean('tech_contract_edit')->default(0);
                    $table->boolean('tech_contract_deactivate')->default(0);
                    $table->boolean('tech_contract_destroy')->default(0);

                    // Chemicals
                    $table->boolean('sup_chemical_index')->default(1);
                    $table->boolean('sup_chemical_create')->default(1);
                    $table->boolean('sup_chemical_show')->default(1);
                    $table->boolean('sup_chemical_edit')->default(1);
                    $table->boolean('sup_chemical_destroy')->default(1);

                    $table->boolean('tech_chemical_index')->default(1);
                    $table->boolean('tech_chemical_create')->default(1);
                    $table->boolean('tech_chemical_show')->default(1);
                    $table->boolean('tech_chemical_edit')->default(0);
                    $table->boolean('tech_chemical_destroy')->default(0);

                    // Equipment
                    $table->boolean('sup_equipment_index')->default(1);
                    $table->boolean('sup_equipment_create')->default(1);
                    $table->boolean('sup_equipment_show')->default(1);
                    $table->boolean('sup_equipment_edit')->default(1);
                    $table->boolean('sup_equipment_addPhoto')->default(1);
                    $table->boolean('sup_equipment_removePhoto')->default(1);
                    $table->boolean('sup_equipment_destroy')->default(1);

                    $table->boolean('tech_equipment_index')->default(1);
                    $table->boolean('tech_equipment_create')->default(1);
                    $table->boolean('tech_equipment_show')->default(1);
                    $table->boolean('tech_equipment_edit')->default(0);
                    $table->boolean('tech_equipment_addPhoto')->default(1);
                    $table->boolean('tech_equipment_removePhoto')->default(0);
                    $table->boolean('tech_equipment_destroy')->default(0);

                // Client
                $table->boolean('sup_client_index')->default(1);
                $table->boolean('sup_client_create')->default(1);
                $table->boolean('sup_client_show')->default(1);
                $table->boolean('sup_client_edit')->default(1);
                $table->boolean('sup_client_destroy')->default(1);

                $table->boolean('tech_client_index')->default(0);
                $table->boolean('tech_client_show')->default(0);

                // Supervisors
                $table->boolean('sup_supervisor_index')->default(1);
                $table->boolean('sup_supervisor_create')->default(1);
                $table->boolean('sup_supervisor_show')->default(1);
                $table->boolean('sup_supervisor_edit')->default(0);
                $table->boolean('sup_supervisor_destroy')->default(0);

                $table->boolean('tech_supervisor_index')->default(1);
                $table->boolean('tech_supervisor_show')->default(0);

                // Technicians
                $table->boolean('sup_technician_index')->default(1);
                $table->boolean('sup_technician_create')->default(1);
                $table->boolean('sup_technician_show')->default(1);
                $table->boolean('sup_technician_edit')->default(1);
                $table->boolean('sup_technician_destroy')->default(1);

                $table->boolean('tech_technician_index')->default(1);
                $table->boolean('tech_technician_show')->default(0);

                // Invoices
                $table->boolean('sup_invoice_index')->default(1);
                $table->boolean('sup_invoice_show')->default(1);
                $table->boolean('sup_invoice_destroy')->default(0);

                $table->boolean('tech_invoice_index')->default(0);
                $table->boolean('tech_invoice_show')->default(0);

                    // payments
                    $table->boolean('sup_payment_index')->default(1);
                    $table->boolean('sup_payment_show')->default(1);
                    $table->boolean('sup_payment_destroy')->default(0);

                    $table->boolean('tech_payment_index')->default(0);
                    $table->boolean('tech_payment_show')->default(0);


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
