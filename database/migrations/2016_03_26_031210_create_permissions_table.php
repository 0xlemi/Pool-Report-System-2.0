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
            $table->string('element');
            $table->string('action');
            $table->string('text');

            $table->unique(['element', 'action']);
            $table->primary('id');
        });

        DB::table('permissions')->insert([
            [ 'id' => 1, 'element' => 'report', 'action' => 'view', 'text' => 'Show Reports' ],
            [ 'id' => 2, 'element' => 'report', 'action' => 'create', 'text' => 'Create New Report' ],
            [ 'id' => 3, 'element' => 'report', 'action' => 'update', 'text' => 'Edit Reports' ],
            [ 'id' => 4, 'element' => 'report', 'action' => 'addPhoto', 'text' => 'Add Photos for Reports' ],
            [ 'id' => 5, 'element' => 'report', 'action' => 'removePhoto', 'text' => 'Remove Photos for Reports' ],
            [ 'id' => 6, 'element' => 'report', 'action' => 'delete', 'text' => 'Delete Report' ],
            [ 'id' => 7, 'element' => 'workorder', 'action' => 'view', 'text' => 'Show Work Orders' ],
            [ 'id' => 8, 'element' => 'workorder', 'action' => 'create', 'text' => 'Create New Work Order' ],
            [ 'id' => 9, 'element' => 'workorder', 'action' => 'update', 'text' => 'Edit Work Orders' ],
            [ 'id' => 10, 'element' => 'workorder', 'action' => 'finish', 'text' => 'Finish Work Orders' ],
            [ 'id' => 11, 'element' => 'workorder', 'action' => 'addPhoto', 'text' => 'Add Before Photos for Work Orders' ],
            [ 'id' => 12, 'element' => 'workorder', 'action' => 'removePhoto', 'text' => 'Remove Photos for Work Orders' ],
            [ 'id' => 13, 'element' => 'workorder', 'action' => 'delete', 'text' => 'Delete Work Orders' ],
            [ 'id' => 14, 'element' => 'work', 'action' => 'view', 'text' => 'Show Works' ],
            [ 'id' => 15, 'element' => 'work', 'action' => 'create', 'text' => 'Create New Work' ],
            [ 'id' => 16, 'element' => 'work', 'action' => 'update', 'text' => 'Edit Work' ],
            [ 'id' => 17, 'element' => 'work', 'action' => 'addPhoto', 'text' => 'Add Before Photos for Work' ],
            [ 'id' => 18, 'element' => 'work', 'action' => 'removePhoto', 'text' => 'Remove Before Photos for Work' ],
            [ 'id' => 19, 'element' => 'work', 'action' => 'delete', 'text' => 'Delete Work' ],
            [ 'id' => 20, 'element' => 'service', 'action' => 'view', 'text' => 'Show Services' ],
            [ 'id' => 21, 'element' => 'service', 'action' => 'create', 'text' => 'Create New Service' ],
            [ 'id' => 22, 'element' => 'service', 'action' => 'update', 'text' => 'Edit Services' ],
            [ 'id' => 23, 'element' => 'service', 'action' => 'delete', 'text' => 'Delete Service' ],
            [ 'id' => 24, 'element' => 'contract', 'action' => 'view', 'text' => 'Show Contract' ],
            [ 'id' => 25, 'element' => 'contract', 'action' => 'create', 'text' => 'Create New Contract' ],
            [ 'id' => 26, 'element' => 'contract', 'action' => 'update', 'text' => 'Edit Contract' ],
            [ 'id' => 27, 'element' => 'contract', 'action' => 'deactivate', 'text' => 'Toggle Contract Activation' ],
            [ 'id' => 28, 'element' => 'contract', 'action' => 'delete', 'text' => 'Delete Contract' ],
            [ 'id' => 29, 'element' => 'chemical', 'action' => 'view', 'text' => 'Show Chemicals' ],
            [ 'id' => 30, 'element' => 'chemical', 'action' => 'create', 'text' => 'Create New Chemical' ],
            [ 'id' => 31, 'element' => 'chemical', 'action' => 'update', 'text' => 'Edit Chemicals' ],
            [ 'id' => 32, 'element' => 'chemical', 'action' => 'delete', 'text' => 'Delete Chemical' ],
            [ 'id' => 33, 'element' => 'equipment', 'action' => 'view', 'text' => 'Show Equipment' ],
            [ 'id' => 34, 'element' => 'equipment', 'action' => 'create', 'text' => 'Create New Equipment' ],
            [ 'id' => 35, 'element' => 'equipment', 'action' => 'update', 'text' => 'Edit Equipment' ],
            [ 'id' => 36, 'element' => 'equipment', 'action' => 'addPhoto', 'text' => 'Add Photos for Equipment' ],
            [ 'id' => 37, 'element' => 'equipment', 'action' => 'removePhoto', 'text' => 'Remove Photos for Equipment' ],
            [ 'id' => 38, 'element' => 'equipment', 'action' => 'delete', 'text' => 'Delete Equipment' ],
            [ 'id' => 39, 'element' => 'client', 'action' => 'view', 'text' => 'Show Clients' ],
            [ 'id' => 40, 'element' => 'client', 'action' => 'create', 'text' => 'Create New Client' ],
            [ 'id' => 41, 'element' => 'client', 'action' => 'update', 'text' => 'Edit Clients' ],
            [ 'id' => 42, 'element' => 'client', 'action' => 'delete', 'text' => 'Delete Client' ],
            [ 'id' => 43, 'element' => 'supervisor', 'action' => 'view', 'text' => 'Show Supervisor' ],
            [ 'id' => 44, 'element' => 'supervisor', 'action' => 'create', 'text' => 'Create New Supervisor' ],
            [ 'id' => 45, 'element' => 'supervisor', 'action' => 'update', 'text' => 'Edit Supervisors' ],
            [ 'id' => 46, 'element' => 'supervisor', 'action' => 'delete', 'text' => 'Delete Supervisor' ],
            [ 'id' => 47, 'element' => 'technician', 'action' => 'view', 'text' => 'Show Technicians' ],
            [ 'id' => 48, 'element' => 'technician', 'action' => 'create', 'text' => 'Create New Technician' ],
            [ 'id' => 49, 'element' => 'technician', 'action' => 'update', 'text' => 'Edit Technicians' ],
            [ 'id' => 50, 'element' => 'technician', 'action' => 'delete', 'text' => 'Delete Technician' ],
            [ 'id' => 51, 'element' => 'invoice', 'action' => 'view', 'text' => 'Show Invoices' ],
            [ 'id' => 52, 'element' => 'invoice', 'action' => 'delete', 'text' => 'Delete Inovices' ],
            [ 'id' => 53, 'element' => 'payment', 'action' => 'view', 'text' => 'Create New Payment' ],
            [ 'id' => 54, 'element' => 'payment', 'action' => 'create', 'text' => 'Show Payments' ],
            [ 'id' => 55, 'element' => 'payment', 'action' => 'delete', 'text' => 'Delete Payments' ],
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
