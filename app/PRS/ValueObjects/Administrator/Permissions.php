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
     * tested
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
            (object)[ 'tag' => "View List Reports" , 'checked' => $admin->sup_report_index, 'name' => 'sup_report_index'],
            (object)[ 'tag' => "Create New Report" , 'checked' => $admin->sup_report_create, 'name' => 'sup_report_create'],
            (object)[ 'tag' => "Show Report Details" , 'checked' => $admin->sup_report_show, 'name' => 'sup_report_show'],
            (object)[ 'tag' => "Edit Reports" , 'checked' => $admin->sup_report_edit, 'name' => 'sup_report_edit'],
            (object)[ 'tag' => "Add Photos for Reports" , 'checked' => $admin->sup_report_addPhoto, 'name' => 'sup_report_addPhoto'],
            (object)[ 'tag' => "Remove Photos for Reports" , 'checked' => $admin->sup_report_removePhoto, 'name' => 'sup_report_removePhoto'],
            (object)[ 'tag' => "Delete Report" , 'checked' => $admin->sup_report_destroy, 'name' => 'sup_report_destroy'],

            (object)[ 'tag' => "View List Reports" , 'checked' => $admin->tech_report_index, 'name' => 'tech_report_index'],
            (object)[ 'tag' => "Create New Report" , 'checked' => $admin->tech_report_create, 'name' => 'tech_report_create'],
            (object)[ 'tag' => "Show Report Details" , 'checked' => $admin->tech_report_show, 'name' => 'tech_report_show'],
            (object)[ 'tag' => "Edit Reports" , 'checked' => $admin->tech_report_edit, 'name' => 'tech_report_edit'],
            (object)[ 'tag' => "Add Photos for Reports" , 'checked' => $admin->tech_report_addPhoto, 'name' => 'tech_report_addPhoto'],
            (object)[ 'tag' => "Remove Photos for Reports" , 'checked' => $admin->tech_report_removePhoto, 'name' => 'tech_report_removePhoto'],
            (object)[ 'tag' => "Delete Report" , 'checked' => $admin->tech_report_destroy, 'name' => 'tech_report_destroy'],

            // Work Order
            (object)[ 'tag' => "View List Work Orders" , 'checked' => $admin->sup_workorder_index, 'name' => 'sup_workorder_index'],
            (object)[ 'tag' => "Create New Work Order" , 'checked' => $admin->sup_workorder_create, 'name' => 'sup_workorder_create'],
            (object)[ 'tag' => "Show Work Order Details" , 'checked' => $admin->sup_workorder_show, 'name' => 'sup_workorder_show'],
            (object)[ 'tag' => "Edit Work Orders" , 'checked' => $admin->sup_workorder_edit, 'name' => 'sup_workorder_edit'],
            (object)[ 'tag' => "Finish Work Orders" , 'checked' => $admin->sup_workorder_finish, 'name' => 'sup_workorder_finish'],
            (object)[ 'tag' => "Add Before Photos for Work Orders" , 'checked' => $admin->sup_workorder_addPhoto, 'name' => 'sup_workorder_addPhoto'],
            (object)[ 'tag' => "Remove Photos for Work Orders" , 'checked' => $admin->sup_workorder_removePhoto, 'name' => 'sup_workorder_removePhoto'],
            (object)[ 'tag' => "Delete Work Orders" , 'checked' => $admin->sup_workorder_destroy, 'name' => 'sup_workorder_destroy'],

            (object)[ 'tag' => "View List Work Orders" , 'checked' => $admin->tech_workorder_index, 'name' => 'tech_workorder_index'],
            (object)[ 'tag' => "Create New Work Order" , 'checked' => $admin->tech_workorder_create, 'name' => 'tech_workorder_create'],
            (object)[ 'tag' => "Show Work Order Details" , 'checked' => $admin->tech_workorder_show, 'name' => 'tech_workorder_show'],
            (object)[ 'tag' => "Edit Work Orders" , 'checked' => $admin->tech_workorder_edit, 'name' => 'tech_workorder_edit'],
            (object)[ 'tag' => "Finish Work Orders" , 'checked' => $admin->tech_workorder_finish, 'name' => 'tech_workorder_finish'],
            (object)[ 'tag' => "Add Before Photos for Work Orders" , 'checked' => $admin->tech_workorder_addPhoto, 'name' => 'tech_workorder_addPhoto'],
            (object)[ 'tag' => "Remove Photos for Work Orders" , 'checked' => $admin->tech_workorder_removePhoto, 'name' => 'tech_workorder_removePhoto'],

                // works
                (object)[ 'tag' => "View List Work" , 'checked' => $admin->sup_work_index, 'name' => 'sup_work_index'],
                (object)[ 'tag' => "Create New Work" , 'checked' => $admin->sup_work_create, 'name' => 'sup_work_create'],
                (object)[ 'tag' => "Show Work Details" , 'checked' => $admin->sup_work_show, 'name' => 'sup_work_show'],
                (object)[ 'tag' => "Edit Work" , 'checked' => $admin->sup_work_edit, 'name' => 'sup_work_edit'],
                (object)[ 'tag' => "Add Before Photos for Work" , 'checked' => $admin->sup_work_addPhoto, 'name' => 'sup_work_addPhoto'],
                (object)[ 'tag' => "Remove Before Photos for Work" , 'checked' => $admin->sup_work_removePhoto, 'name' => 'sup_work_removePhoto'],
                (object)[ 'tag' => "Delete Work" , 'checked' => $admin->sup_work_destroy, 'name' => 'sup_work_destroy'],

                (object)[ 'tag' => "View List Work" , 'checked' => $admin->tech_work_index, 'name' => 'tech_work_index'],
                (object)[ 'tag' => "Create New Work" , 'checked' => $admin->tech_work_create, 'name' => 'tech_work_create'],
                (object)[ 'tag' => "Show Work Details" , 'checked' => $admin->tech_work_show, 'name' => 'tech_work_show'],
                (object)[ 'tag' => "Edit Work" , 'checked' => $admin->tech_work_edit, 'name' => 'tech_work_edit'],
                (object)[ 'tag' => "Add Before Photos for Work" , 'checked' => $admin->tech_work_addPhoto, 'name' => 'tech_work_addPhoto'],
                (object)[ 'tag' => "Remove Before Photos for Work" , 'checked' => $admin->tech_work_removePhoto, 'name' => 'tech_work_removePhoto'],
                (object)[ 'tag' => "Delete Work" , 'checked' => $admin->tech_work_destroy, 'name' => 'tech_work_destroy'],

            // Service
            (object)[ 'tag' => "View List Services" , 'checked' => $admin->sup_service_index, 'name' => 'sup_service_index'],
            (object)[ 'tag' => "Create New Service" , 'checked' => $admin->sup_service_create, 'name' => 'sup_service_create'],
            (object)[ 'tag' => "Show Service Details" , 'checked' => $admin->sup_service_show, 'name' => 'sup_service_show'],
            (object)[ 'tag' => "Edit Services" , 'checked' => $admin->sup_service_edit, 'name' => 'sup_service_edit'],
            (object)[ 'tag' => "Delete Service" , 'checked' => $admin->sup_service_destroy, 'name' => 'sup_service_destroy'],

            (object)[ 'tag' => "View List Services" , 'checked' => $admin->tech_service_index, 'name' => 'tech_service_index'],
            (object)[ 'tag' => "Create New Service" , 'checked' => $admin->tech_service_create, 'name' => 'tech_service_create'],
            (object)[ 'tag' => "Show Service Details" , 'checked' => $admin->tech_service_show, 'name' => 'tech_service_show'],
            (object)[ 'tag' => "Edit Services" , 'checked' => $admin->tech_service_edit, 'name' => 'tech_service_edit'],

                // Contract
                (object)[ 'tag' => "Create New Contract" , 'checked' => $admin->sup_contract_create, 'name' => 'sup_contract_create'],
                (object)[ 'tag' => "Show Contract Details" , 'checked' => $admin->sup_contract_show, 'name' => 'sup_contract_show'],
                (object)[ 'tag' => "Edit Contract" , 'checked' => $admin->sup_contract_edit, 'name' => 'sup_contract_edit'],
                (object)[ 'tag' => "Deactivate Contract" , 'checked' => $admin->sup_contract_deactivate, 'name' => 'sup_contract_deactivate'],
                (object)[ 'tag' => "Delete Contract" , 'checked' => $admin->sup_contract_destroy, 'name' => 'sup_contract_destroy'],

                (object)[ 'tag' => "Create New Contract" , 'checked' => $admin->tech_contract_create, 'name' => 'tech_contract_create'],
                (object)[ 'tag' => "Show Contract Details" , 'checked' => $admin->tech_contract_show, 'name' => 'tech_contract_show'],
                (object)[ 'tag' => "Edit Contract" , 'checked' => $admin->tech_contract_edit, 'name' => 'tech_contract_edit'],
                (object)[ 'tag' => "Deactivate Contract" , 'checked' => $admin->tech_contract_deactivate, 'name' => 'tech_contract_deactivate'],
                (object)[ 'tag' => "Delete Contract" , 'checked' => $admin->tech_contract_destroy, 'name' => 'tech_contract_destroy'],

                // Chemicals
                (object)[ 'tag' => "View List Chemicals" , 'checked' => $admin->sup_chemical_index, 'name' => 'sup_chemical_index'],
                (object)[ 'tag' => "Create New Chemical" , 'checked' => $admin->sup_chemical_create, 'name' => 'sup_chemical_create'],
                (object)[ 'tag' => "Show Chemical Details" , 'checked' => $admin->sup_chemical_show, 'name' => 'sup_chemical_show'],
                (object)[ 'tag' => "Edit Chemicals" , 'checked' => $admin->sup_chemical_edit, 'name' => 'sup_chemical_edit'],
                (object)[ 'tag' => "Delete Chemical" , 'checked' => $admin->sup_chemical_destroy, 'name' => 'sup_chemical_destroy'],

                (object)[ 'tag' => "View List Chemicals" , 'checked' => $admin->tech_chemical_index, 'name' => 'tech_chemical_index'],
                (object)[ 'tag' => "Create New Chemical" , 'checked' => $admin->tech_chemical_create, 'name' => 'tech_chemical_create'],
                (object)[ 'tag' => "Show Chemical Details" , 'checked' => $admin->tech_chemical_show, 'name' => 'tech_chemical_show'],
                (object)[ 'tag' => "Edit Chemicals" , 'checked' => $admin->tech_chemical_edit, 'name' => 'tech_chemical_edit'],
                (object)[ 'tag' => "Delete Chemical" , 'checked' => $admin->tech_chemical_destroy, 'name' => 'tech_chemical_destroy'],

                // Equipment
                (object)[ 'tag' => "View List Equipment" , 'checked' => $admin->sup_equipment_index, 'name' => 'sup_equipment_index'],
                (object)[ 'tag' => "Create New Equipment" , 'checked' => $admin->sup_equipment_create, 'name' => 'sup_equipment_create'],
                (object)[ 'tag' => "Show Equipment Details" , 'checked' => $admin->sup_equipment_show, 'name' => 'sup_equipment_show'],
                (object)[ 'tag' => "Edit Equipment" , 'checked' => $admin->sup_equipment_edit, 'name' => 'sup_equipment_edit'],
                (object)[ 'tag' => "Add Photos for Equipment" , 'checked' => $admin->sup_equipment_addPhoto, 'name' => 'sup_equipment_addPhoto'],
                (object)[ 'tag' => "Remove Photos for Equipment" , 'checked' => $admin->sup_equipment_removePhoto, 'name' => 'sup_equipment_removePhoto'],
                (object)[ 'tag' => "Delete Equipment" , 'checked' => $admin->sup_equipment_destroy, 'name' => 'sup_equipment_destroy'],

                (object)[ 'tag' => "View List Equipment" , 'checked' => $admin->tech_equipment_index, 'name' => 'tech_equipment_index'],
                (object)[ 'tag' => "Create New Equipment" , 'checked' => $admin->tech_equipment_create, 'name' => 'tech_equipment_create'],
                (object)[ 'tag' => "Show Equipment Details" , 'checked' => $admin->tech_equipment_show, 'name' => 'tech_equipment_show'],
                (object)[ 'tag' => "Edit Equipment" , 'checked' => $admin->tech_equipment_edit, 'name' => 'tech_equipment_edit'],
                (object)[ 'tag' => "Add Photos for Equipment" , 'checked' => $admin->tech_equipment_addPhoto, 'name' => 'tech_equipment_addPhoto'],
                (object)[ 'tag' => "Remove Photos for Equipment" , 'checked' => $admin->tech_equipment_removePhoto, 'name' => 'tech_equipment_removePhoto'],
                (object)[ 'tag' => "Delete Equipment" , 'checked' => $admin->tech_equipment_destroy, 'name' => 'tech_equipment_destroy'],

            // Client
            (object)[ 'tag' => "View List Clients", 'checked' => $admin->sup_client_index, 'name' => 'sup_client_index'],
            (object)[ 'tag' => "Create New Client" , 'checked' => $admin->sup_client_create, 'name' => 'sup_client_create'],
            (object)[ 'tag' => "Show Client Details" , 'checked' => $admin->sup_client_show, 'name' => 'sup_client_show'],
            (object)[ 'tag' => "Edit Clients" , 'checked' => $admin->sup_client_edit, 'name' => 'sup_client_edit'],
            (object)[ 'tag' => "Delete Client" , 'checked' => $admin->sup_client_destroy, 'name' => 'sup_client_destroy'],

            (object)[ 'tag' => "View List Clients" , 'checked' => $admin->tech_client_index, 'name' => 'tech_client_index'],
            (object)[ 'tag' => "Show Client Details" , 'checked' => $admin->tech_client_show, 'name' => 'tech_client_show'],

            // Supervisor
            (object)[ 'tag' => "View List Supervisors", 'checked' => $admin->sup_supervisor_index, 'name' => 'sup_supervisor_index'],
            (object)[ 'tag' => "Create New Supervisor" , 'checked' => $admin->sup_supervisor_create, 'name' => 'sup_supervisor_create'],
            (object)[ 'tag' => "Show Supervisor Details" , 'checked' => $admin->sup_supervisor_show, 'name' => 'sup_supervisor_show'],
            (object)[ 'tag' => "Edit Supervisors" , 'checked' => $admin->sup_supervisor_edit, 'name' => 'sup_supervisor_edit'],
            (object)[ 'tag' => "Delete Supervisor" , 'checked' => $admin->sup_supervisor_destroy, 'name' => 'sup_supervisor_destroy'],

            (object)[ 'tag' => "View List Supervisors" , 'checked' => $admin->tech_supervisor_index, 'name' => 'tech_supervisor_index'],
            (object)[ 'tag' => "Show Supervisor Details" , 'checked' => $admin->tech_supervisor_show, 'name' => 'tech_supervisor_show'],

            // Technician
            (object)[ 'tag' => "View List Technicians", 'checked' => $admin->sup_technician_index, 'name' => 'sup_technician_index'],
            (object)[ 'tag' => "Create New Technician" , 'checked' => $admin->sup_technician_create, 'name' => 'sup_technician_create'],
            (object)[ 'tag' => "Show Technician Details" , 'checked' => $admin->sup_technician_show, 'name' => 'sup_technician_show'],
            (object)[ 'tag' => "Edit Technicians" , 'checked' => $admin->sup_technician_edit, 'name' => 'sup_technician_edit'],
            (object)[ 'tag' => "Delete Technician" , 'checked' => $admin->sup_technician_destroy, 'name' => 'sup_technician_destroy'],

            (object)[ 'tag' => "View List Technicians" , 'checked' => $admin->tech_technician_index, 'name' => 'tech_technician_index'],
            (object)[ 'tag' => "Show Technician Details" , 'checked' => $admin->tech_technician_show, 'name' => 'tech_technician_show'],

            // Inovices
            (object)[ 'tag' => "View List Invoices", 'checked' => $admin->sup_invoice_index, 'name' => 'sup_invoice_index'],
            (object)[ 'tag' => "Show Invoices Details" , 'checked' => $admin->sup_invoice_show, 'name' => 'sup_invoice_show'],
            (object)[ 'tag' => "Delete Inovices" , 'checked' => $admin->sup_invoice_destroy, 'name' => 'sup_invoice_destroy'],

            (object)[ 'tag' => "View List Invoices", 'checked' => $admin->tech_invoice_index, 'name' => 'tech_invoice_index'],
            (object)[ 'tag' => "Show Invoices Details" , 'checked' => $admin->tech_invoice_show, 'name' => 'tech_invoice_show'],

                // Payments
                (object)[ 'tag' => "View List Payments", 'checked' => $admin->sup_payment_index, 'name' => 'sup_payment_index'],
                (object)[ 'tag' => "Show Payments Details" , 'checked' => $admin->sup_payment_show, 'name' => 'sup_payment_show'],
                (object)[ 'tag' => "Delete Inovices" , 'checked' => $admin->sup_payment_destroy, 'name' => 'sup_payment_destroy'],

                (object)[ 'tag' => "View List Payments", 'checked' => $admin->tech_payment_index, 'name' => 'tech_payment_index'],
                (object)[ 'tag' => "Show Payments Details" , 'checked' => $admin->tech_payment_show, 'name' => 'tech_payment_show'],

        ];
    }

}
