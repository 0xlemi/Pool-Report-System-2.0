<?php

namespace App\PRS\ValueObjects\Administrator;
use App\Administrator;


class Permissions {


    protected $permissions;

    public function __construct(Administrator $admin)
    {
        $this->permissions = $this->buildPermissions($admin);
    }

    /**
     * Get the permissions that consern the supervisor role
     * @param  string $object permission over what object
     * @return array         array of objects
     * tested
     */
    public function supervisor($object = null)
    {
        return $this->filterPermissions('sup', $object);
    }

    /**
     * Get the permissions that consern the technician role
     * @param  string $object permission over what object
     * @return array         array of objects
     * tested
     */
    public function technician($object = null)
    {
        return $this->filterPermissions('tech', $object);
    }

    /**
     * Filter Permission depending on the name
     * @param  string $user   the role that has the permission
     * @param  string $object the object in which the acction is made
     * @return array
     */
    protected function filterPermissions($user, $object)
    {
        $result = [];
        foreach ($this->permissions as $value) {
            $explode =explode('_', $value->name);
            // check the user
            if($explode[0] == $user){
                if($object){
                    // if Object is set return permissions that relate to the object
                    if($object == $explode[1]){
                        $result[] = $value;
                    }
                // if Object is null return all
                }else{
                    $result[] = $value;
                }
            }
        }
        return $result;
    }

    /**
     * Get all the permissions devided into sections
     * @param  string $user   the role that has the permission
     * @return array
     */
    public function permissionsDivided($user)
    {
        return [
            'report' => $this->filterPermissions($user, 'report'),
            'workorder' => [
                            'this' => $this->filterPermissions($user, 'workorder'),
                            'work' => $this->filterPermissions($user, 'work')
                        ],
            'service' => [
                            'this' => $this->filterPermissions($user, 'service'),
                            'contract' =>  $this->filterPermissions($user, 'contract'),
                            'chemical' => $this->filterPermissions($user, 'chemical'),
                            'equipment' => $this->filterPermissions($user, 'equipment')
                        ],
            'client' => $this->filterPermissions($user, 'client'),
            'supervisor' => $this->filterPermissions($user, 'supervisor'),
            'technician' => $this->filterPermissions($user, 'technician'),
            'invoice' => [
                            'this' => $this->filterPermissions($user, 'invoice'),
                            'payments' => $this->filterPermissions($user, 'payment')
                        ],
        ];
    }

    // Get all the premissions and tags for the admin
    protected function buildPermissions(Administrator $admin)
    {
        return [

            // Report
            (object)[ 'tag' => "Show Reports" , 'checked' => $admin->sup_report_view, 'name' => 'sup_report_view'],
            (object)[ 'tag' => "Create New Report" , 'checked' => $admin->sup_report_create, 'name' => 'sup_report_create'],
            (object)[ 'tag' => "Edit Reports" , 'checked' => $admin->sup_report_update, 'name' => 'sup_report_update'],
            (object)[ 'tag' => "Add Photos for Reports" , 'checked' => $admin->sup_report_addPhoto, 'name' => 'sup_report_addPhoto'],
            (object)[ 'tag' => "Remove Photos for Reports" , 'checked' => $admin->sup_report_removePhoto, 'name' => 'sup_report_removePhoto'],
            (object)[ 'tag' => "Delete Report" , 'checked' => $admin->sup_report_delete, 'name' => 'sup_report_delete'],

            (object)[ 'tag' => "Show Reports" , 'checked' => $admin->tech_report_view, 'name' => 'tech_report_view'],
            (object)[ 'tag' => "Create New Report" , 'checked' => $admin->tech_report_create, 'name' => 'tech_report_create'],
            (object)[ 'tag' => "Edit Reports" , 'checked' => $admin->tech_report_update, 'name' => 'tech_report_update'],
            (object)[ 'tag' => "Add Photos for Reports" , 'checked' => $admin->tech_report_addPhoto, 'name' => 'tech_report_addPhoto'],
            (object)[ 'tag' => "Remove Photos for Reports" , 'checked' => $admin->tech_report_removePhoto, 'name' => 'tech_report_removePhoto'],
            (object)[ 'tag' => "Delete Report" , 'checked' => $admin->tech_report_delete, 'name' => 'tech_report_delete'],

            // Work Order
            (object)[ 'tag' => "Show Work Orders" , 'checked' => $admin->sup_workorder_view, 'name' => 'sup_workorder_view'],
            (object)[ 'tag' => "Create New Work Order" , 'checked' => $admin->sup_workorder_create, 'name' => 'sup_workorder_create'],
            (object)[ 'tag' => "Edit Work Orders" , 'checked' => $admin->sup_workorder_update, 'name' => 'sup_workorder_update'],
            (object)[ 'tag' => "Finish Work Orders" , 'checked' => $admin->sup_workorder_finish, 'name' => 'sup_workorder_finish'],
            (object)[ 'tag' => "Add Before Photos for Work Orders" , 'checked' => $admin->sup_workorder_addPhoto, 'name' => 'sup_workorder_addPhoto'],
            (object)[ 'tag' => "Remove Photos for Work Orders" , 'checked' => $admin->sup_workorder_removePhoto, 'name' => 'sup_workorder_removePhoto'],
            (object)[ 'tag' => "Delete Work Orders" , 'checked' => $admin->sup_workorder_delete, 'name' => 'sup_workorder_delete'],

            (object)[ 'tag' => "Show Work Orders" , 'checked' => $admin->tech_workorder_view, 'name' => 'tech_workorder_view'],
            (object)[ 'tag' => "Create New Work Order" , 'checked' => $admin->tech_workorder_create, 'name' => 'tech_workorder_create'],
            (object)[ 'tag' => "Edit Work Orders" , 'checked' => $admin->tech_workorder_update, 'name' => 'tech_workorder_update'],
            (object)[ 'tag' => "Finish Work Orders" , 'checked' => $admin->tech_workorder_finish, 'name' => 'tech_workorder_finish'],
            (object)[ 'tag' => "Add Before Photos for Work Orders" , 'checked' => $admin->tech_workorder_addPhoto, 'name' => 'tech_workorder_addPhoto'],
            (object)[ 'tag' => "Remove Photos for Work Orders" , 'checked' => $admin->tech_workorder_removePhoto, 'name' => 'tech_workorder_removePhoto'],

                // works
                (object)[ 'tag' => "Show Works" , 'checked' => $admin->sup_work_view, 'name' => 'sup_work_view'],
                (object)[ 'tag' => "Create New Work" , 'checked' => $admin->sup_work_create, 'name' => 'sup_work_create'],
                (object)[ 'tag' => "Edit Work" , 'checked' => $admin->sup_work_update, 'name' => 'sup_work_update'],
                (object)[ 'tag' => "Add Before Photos for Work" , 'checked' => $admin->sup_work_addPhoto, 'name' => 'sup_work_addPhoto'],
                (object)[ 'tag' => "Remove Before Photos for Work" , 'checked' => $admin->sup_work_removePhoto, 'name' => 'sup_work_removePhoto'],
                (object)[ 'tag' => "Delete Work" , 'checked' => $admin->sup_work_delete, 'name' => 'sup_work_delete'],

                (object)[ 'tag' => "Show Works" , 'checked' => $admin->tech_work_view, 'name' => 'tech_work_view'],
                (object)[ 'tag' => "Create New Work" , 'checked' => $admin->tech_work_create, 'name' => 'tech_work_create'],
                (object)[ 'tag' => "Edit Work" , 'checked' => $admin->tech_work_update, 'name' => 'tech_work_update'],
                (object)[ 'tag' => "Add Before Photos for Work" , 'checked' => $admin->tech_work_addPhoto, 'name' => 'tech_work_addPhoto'],
                (object)[ 'tag' => "Remove Before Photos for Work" , 'checked' => $admin->tech_work_removePhoto, 'name' => 'tech_work_removePhoto'],
                (object)[ 'tag' => "Delete Work" , 'checked' => $admin->tech_work_delete, 'name' => 'tech_work_delete'],

            // Service
            (object)[ 'tag' => "Show Services" , 'checked' => $admin->sup_service_view, 'name' => 'sup_service_view'],
            (object)[ 'tag' => "Create New Service" , 'checked' => $admin->sup_service_create, 'name' => 'sup_service_create'],
            (object)[ 'tag' => "Edit Services" , 'checked' => $admin->sup_service_update, 'name' => 'sup_service_update'],
            (object)[ 'tag' => "Delete Service" , 'checked' => $admin->sup_service_delete, 'name' => 'sup_service_delete'],

            (object)[ 'tag' => "Show Services" , 'checked' => $admin->tech_service_view, 'name' => 'tech_service_view'],
            (object)[ 'tag' => "Create New Service" , 'checked' => $admin->tech_service_create, 'name' => 'tech_service_create'],
            (object)[ 'tag' => "Edit Services" , 'checked' => $admin->tech_service_update, 'name' => 'tech_service_update'],

                // Contract
                (object)[ 'tag' => "Show Contract" , 'checked' => $admin->sup_contract_view, 'name' => 'sup_contract_view'],
                (object)[ 'tag' => "Create New Contract" , 'checked' => $admin->sup_contract_create, 'name' => 'sup_contract_create'],
                (object)[ 'tag' => "Edit Contract" , 'checked' => $admin->sup_contract_update, 'name' => 'sup_contract_update'],
                (object)[ 'tag' => "Toggle Contract Activation" , 'checked' => $admin->sup_contract_deactivate, 'name' => 'sup_contract_deactivate'],
                (object)[ 'tag' => "Delete Contract" , 'checked' => $admin->sup_contract_delete, 'name' => 'sup_contract_delete'],

                (object)[ 'tag' => "Show Contract" , 'checked' => $admin->tech_contract_view, 'name' => 'tech_contract_view'],
                (object)[ 'tag' => "Create New Contract" , 'checked' => $admin->tech_contract_create, 'name' => 'tech_contract_create'],
                (object)[ 'tag' => "Edit Contract" , 'checked' => $admin->tech_contract_update, 'name' => 'tech_contract_update'],
                (object)[ 'tag' => "Toggle Contract Activation" , 'checked' => $admin->tech_contract_deactivate, 'name' => 'tech_contract_deactivate'],
                (object)[ 'tag' => "Delete Contract" , 'checked' => $admin->tech_contract_delete, 'name' => 'tech_contract_delete'],

                // Chemicals
                (object)[ 'tag' => "Show Chemicals" , 'checked' => $admin->sup_chemical_view, 'name' => 'sup_chemical_view'],
                (object)[ 'tag' => "Create New Chemical" , 'checked' => $admin->sup_chemical_create, 'name' => 'sup_chemical_create'],
                (object)[ 'tag' => "Edit Chemicals" , 'checked' => $admin->sup_chemical_update, 'name' => 'sup_chemical_update'],
                (object)[ 'tag' => "Delete Chemical" , 'checked' => $admin->sup_chemical_delete, 'name' => 'sup_chemical_delete'],

                (object)[ 'tag' => "Show Chemicals" , 'checked' => $admin->tech_chemical_view, 'name' => 'tech_chemical_view'],
                (object)[ 'tag' => "Create New Chemical" , 'checked' => $admin->tech_chemical_create, 'name' => 'tech_chemical_create'],
                (object)[ 'tag' => "Edit Chemicals" , 'checked' => $admin->tech_chemical_update, 'name' => 'tech_chemical_update'],
                (object)[ 'tag' => "Delete Chemical" , 'checked' => $admin->tech_chemical_delete, 'name' => 'tech_chemical_delete'],

                // Equipment
                (object)[ 'tag' => "Show Equipment" , 'checked' => $admin->sup_equipment_view, 'name' => 'sup_equipment_view'],
                (object)[ 'tag' => "Create New Equipment" , 'checked' => $admin->sup_equipment_create, 'name' => 'sup_equipment_create'],
                (object)[ 'tag' => "Edit Equipment" , 'checked' => $admin->sup_equipment_update, 'name' => 'sup_equipment_update'],
                (object)[ 'tag' => "Add Photos for Equipment" , 'checked' => $admin->sup_equipment_addPhoto, 'name' => 'sup_equipment_addPhoto'],
                (object)[ 'tag' => "Remove Photos for Equipment" , 'checked' => $admin->sup_equipment_removePhoto, 'name' => 'sup_equipment_removePhoto'],
                (object)[ 'tag' => "Delete Equipment" , 'checked' => $admin->sup_equipment_delete, 'name' => 'sup_equipment_delete'],

                (object)[ 'tag' => "Show Equipment" , 'checked' => $admin->tech_equipment_view, 'name' => 'tech_equipment_view'],
                (object)[ 'tag' => "Create New Equipment" , 'checked' => $admin->tech_equipment_create, 'name' => 'tech_equipment_create'],
                (object)[ 'tag' => "Edit Equipment" , 'checked' => $admin->tech_equipment_update, 'name' => 'tech_equipment_update'],
                (object)[ 'tag' => "Add Photos for Equipment" , 'checked' => $admin->tech_equipment_addPhoto, 'name' => 'tech_equipment_addPhoto'],
                (object)[ 'tag' => "Remove Photos for Equipment" , 'checked' => $admin->tech_equipment_removePhoto, 'name' => 'tech_equipment_removePhoto'],
                (object)[ 'tag' => "Delete Equipment" , 'checked' => $admin->tech_equipment_delete, 'name' => 'tech_equipment_delete'],

            // Client
            (object)[ 'tag' => "Show Clients" , 'checked' => $admin->sup_client_view, 'name' => 'sup_client_view'],
            (object)[ 'tag' => "Create New Client" , 'checked' => $admin->sup_client_create, 'name' => 'sup_client_create'],
            (object)[ 'tag' => "Edit Clients" , 'checked' => $admin->sup_client_update, 'name' => 'sup_client_update'],
            (object)[ 'tag' => "Delete Client" , 'checked' => $admin->sup_client_delete, 'name' => 'sup_client_delete'],

            (object)[ 'tag' => "Show Clients" , 'checked' => $admin->tech_client_view, 'name' => 'tech_client_view'],

            // Supervisor
            (object)[ 'tag' => "Show Supervisor" , 'checked' => $admin->sup_supervisor_view, 'name' => 'sup_supervisor_view'],
            (object)[ 'tag' => "Create New Supervisor" , 'checked' => $admin->sup_supervisor_create, 'name' => 'sup_supervisor_create'],
            (object)[ 'tag' => "Edit Supervisors" , 'checked' => $admin->sup_supervisor_update, 'name' => 'sup_supervisor_update'],
            (object)[ 'tag' => "Delete Supervisor" , 'checked' => $admin->sup_supervisor_delete, 'name' => 'sup_supervisor_delete'],

            (object)[ 'tag' => "Show Supervisor" , 'checked' => $admin->tech_supervisor_view, 'name' => 'tech_supervisor_view'],

            // Technician
            (object)[ 'tag' => "Show Technicians" , 'checked' => $admin->sup_technician_view, 'name' => 'sup_technician_view'],
            (object)[ 'tag' => "Create New Technician" , 'checked' => $admin->sup_technician_create, 'name' => 'sup_technician_create'],
            (object)[ 'tag' => "Edit Technicians" , 'checked' => $admin->sup_technician_update, 'name' => 'sup_technician_update'],
            (object)[ 'tag' => "Delete Technician" , 'checked' => $admin->sup_technician_delete, 'name' => 'sup_technician_delete'],

            (object)[ 'tag' => "Show Technicians" , 'checked' => $admin->tech_technician_view, 'name' => 'tech_technician_view'],

            // Inovices
            (object)[ 'tag' => "Show Invoices" , 'checked' => $admin->sup_invoice_view, 'name' => 'sup_invoice_view'],
            (object)[ 'tag' => "Delete Inovices" , 'checked' => $admin->sup_invoice_delete, 'name' => 'sup_invoice_delete'],

            (object)[ 'tag' => "Show Invoices" , 'checked' => $admin->tech_invoice_view, 'name' => 'tech_invoice_view'],

                // Payments
                (object)[ 'tag' => "Create New Payment" , 'checked' => $admin->sup_payment_create, 'name' => 'sup_payment_create'],
                (object)[ 'tag' => "Show Payments" , 'checked' => $admin->sup_payment_view, 'name' => 'sup_payment_view'],
                (object)[ 'tag' => "Delete Inovices" , 'checked' => $admin->sup_payment_delete, 'name' => 'sup_payment_delete'],

                (object)[ 'tag' => "Create New Payment" , 'checked' => $admin->tech_payment_create, 'name' => 'tech_payment_create'],
                (object)[ 'tag' => "Show Payments" , 'checked' => $admin->tech_payment_view, 'name' => 'tech_payment_view'],

        ];
    }

}
