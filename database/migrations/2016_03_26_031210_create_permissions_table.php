<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id')->unsigned();
            $table->string('name');
            $table->string('text');

            $table->primary('id');
        });

        DB::table('permissions')->insert([
            [ 'id' => 1, 'name' =>'report_view', 'text' => 'Show Reports' ],
            [ 'id' => 2, 'name' =>'report_create', 'text' => 'Create New Report' ],
            [ 'id' => 3, 'name' =>'report_update', 'text' => 'Edit Reports' ],
            [ 'id' => 4, 'name' =>'report_addPhoto', 'text' => 'Add Photos for Reports' ],
            [ 'id' => 5, 'name' =>'report_removePhoto', 'text' => 'Remove Photos for Reports' ],
            [ 'id' => 6, 'name' =>'report_delete', 'text' => 'Delete Report' ],
            [ 'id' => 7, 'name' =>'workorder_view', 'text' => 'Show Work Orders' ],
            [ 'id' => 8, 'name' =>'workorder_create', 'text' => 'Create New Work Order' ],
            [ 'id' => 9, 'name' =>'workorder_update', 'text' => 'Edit Work Orders' ],
            [ 'id' => 10, 'name' =>'workorder_finish', 'text' => 'Finish Work Orders' ],
            [ 'id' => 11, 'name' =>'workorder_addPhoto', 'text' => 'Add Before Photos for Work Orders' ],
            [ 'id' => 12, 'name' =>'workorder_removePhoto', 'text' => 'Remove Photos for Work Orders' ],
            [ 'id' => 13, 'name' =>'workorder_delete', 'text' => 'Delete Work Orders' ],
            [ 'id' => 14, 'name' =>'work_view', 'text' => 'Show Works' ],
            [ 'id' => 15, 'name' =>'work_create', 'text' => 'Create New Work' ],
            [ 'id' => 16, 'name' =>'work_update', 'text' => 'Edit Work' ],
            [ 'id' => 17, 'name' =>'work_addPhoto', 'text' => 'Add Before Photos for Work' ],
            [ 'id' => 18, 'name' =>'work_removePhoto', 'text' => 'Remove Before Photos for Work' ],
            [ 'id' => 19, 'name' =>'work_delete', 'text' => 'Delete Work' ],
            [ 'id' => 20, 'name' =>'service_view', 'text' => 'Show Services' ],
            [ 'id' => 21, 'name' =>'service_create', 'text' => 'Create New Service' ],
            [ 'id' => 22, 'name' =>'service_update', 'text' => 'Edit Services' ],
            [ 'id' => 23, 'name' =>'service_delete', 'text' => 'Delete Service' ],
            [ 'id' => 24, 'name' =>'contract_view', 'text' => 'Show Contract' ],
            [ 'id' => 25, 'name' =>'contract_create', 'text' => 'Create New Contract' ],
            [ 'id' => 26, 'name' =>'contract_update', 'text' => 'Edit Contract' ],
            [ 'id' => 27, 'name' =>'contract_deactivate', 'text' => 'Toggle Contract Activation' ],
            [ 'id' => 28, 'name' =>'contract_delete', 'text' => 'Delete Contract' ],
            [ 'id' => 29, 'name' =>'chemical_view', 'text' => 'Show Chemicals' ],
            [ 'id' => 30, 'name' =>'chemical_create', 'text' => 'Create New Chemical' ],
            [ 'id' => 31, 'name' =>'chemical_update', 'text' => 'Edit Chemicals' ],
            [ 'id' => 32, 'name' =>'chemical_delete', 'text' => 'Delete Chemical' ],
            [ 'id' => 33, 'name' =>'equipment_view', 'text' => 'Show Equipment' ],
            [ 'id' => 34, 'name' =>'equipment_create', 'text' => 'Create New Equipment' ],
            [ 'id' => 35, 'name' =>'equipment_update', 'text' => 'Edit Equipment' ],
            [ 'id' => 36, 'name' =>'equipment_addPhoto', 'text' => 'Add Photos for Equipment' ],
            [ 'id' => 37, 'name' =>'equipment_removePhoto', 'text' => 'Remove Photos for Equipment' ],
            [ 'id' => 38, 'name' =>'equipment_delete', 'text' => 'Delete Equipment' ],
            [ 'id' => 39, 'name' =>'client_view', 'text' => 'Show Clients' ],
            [ 'id' => 40, 'name' =>'client_create', 'text' => 'Create New Client' ],
            [ 'id' => 41, 'name' =>'client_update', 'text' => 'Edit Clients' ],
            [ 'id' => 42, 'name' =>'client_delete', 'text' => 'Delete Client' ],
            [ 'id' => 43, 'name' =>'supervisor_view', 'text' => 'Show Supervisor' ],
            [ 'id' => 44, 'name' =>'supervisor_create', 'text' => 'Create New Supervisor' ],
            [ 'id' => 45, 'name' =>'supervisor_update', 'text' => 'Edit Supervisors' ],
            [ 'id' => 46, 'name' =>'supervisor_delete', 'text' => 'Delete Supervisor' ],
            [ 'id' => 47, 'name' =>'technician_view', 'text' => 'Show Technicians' ],
            [ 'id' => 48, 'name' =>'technician_create', 'text' => 'Create New Technician' ],
            [ 'id' => 49, 'name' =>'technician_update', 'text' => 'Edit Technicians' ],
            [ 'id' => 50, 'name' =>'technician_delete', 'text' => 'Delete Technician' ],
            [ 'id' => 51, 'name' =>'invoice_view', 'text' => 'Show Invoices' ],
            [ 'id' => 52, 'name' =>'invoice_delete', 'text' => 'Delete Inovices' ],
            [ 'id' => 53, 'name' =>'payment_view', 'text' => 'Create New Payment' ],
            [ 'id' => 54, 'name' =>'payment_create', 'text' => 'Show Payments' ],
            [ 'id' => 55, 'name' =>'payment_delete', 'text' => 'Delete Payments' ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
