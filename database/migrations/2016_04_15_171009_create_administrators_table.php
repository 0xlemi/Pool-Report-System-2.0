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
            // Email Preferences
                $table->boolean('get_reports_emails')->default(0);
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
                $table->boolean('tech_service_destroy')->default(0);
                // Client
                $table->boolean('sup_client_index')->default(1);
                $table->boolean('sup_client_create')->default(1);
                $table->boolean('sup_client_show')->default(1);
                $table->boolean('sup_client_edit')->default(1);
                $table->boolean('sup_client_destroy')->default(1);
                $table->boolean('tech_client_index')->default(1);
                $table->boolean('tech_client_create')->default(0);
                $table->boolean('tech_client_show')->default(0);
                $table->boolean('tech_client_edit')->default(0);
                $table->boolean('tech_client_destroy')->default(0);
                // Supervisors
                $table->boolean('sup_supervisor_index')->default(1);
                $table->boolean('sup_supervisor_create')->default(1);
                $table->boolean('sup_supervisor_show')->default(1);
                $table->boolean('sup_supervisor_edit')->default(0);
                $table->boolean('sup_supervisor_destroy')->default(0);
                $table->boolean('tech_supervisor_index')->default(1);
                $table->boolean('tech_supervisor_create')->default(0);
                $table->boolean('tech_supervisor_show')->default(0);
                $table->boolean('tech_supervisor_edit')->default(0);
                $table->boolean('tech_supervisor_destroy')->default(0);
                // Technicians
                $table->boolean('sup_technician_index')->default(1);
                $table->boolean('sup_technician_create')->default(1);
                $table->boolean('sup_technician_show')->default(1);
                $table->boolean('sup_technician_edit')->default(1);
                $table->boolean('sup_technician_destroy')->default(1);
                $table->boolean('tech_technician_index')->default(1);
                $table->boolean('tech_technician_create')->default(0);
                $table->boolean('tech_technician_show')->default(0);
                $table->boolean('tech_technician_edit')->default(0);
                $table->boolean('tech_technician_destroy')->default(0);

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
