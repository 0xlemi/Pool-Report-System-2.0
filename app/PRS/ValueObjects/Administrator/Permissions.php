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
            'service' => $this->filterPermissions($user, 'service'),
            'client' => $this->filterPermissions($user, 'client'),
            'supervisor' => $this->filterPermissions($user, 'supervisor'),
            'technician' => $this->filterPermissions($user, 'technician'),
        ];
    }

    // Get all the premissions and tags from the admin
    protected function buildPermissions(Administrator $admin)
    {
        return [
            // Report
            (object)[ 'tag' => "View List Reports" , 'checked' => $admin->sup_report_index, 'name' => 'sup_report_index'],
            (object)[ 'tag' => "Create New Report" , 'checked' => $admin->sup_report_create, 'name' => 'sup_report_create'],
            (object)[ 'tag' => "Show Report Details" , 'checked' => $admin->sup_report_show, 'name' => 'sup_report_show'],
            (object)[ 'tag' => "Edit Reports" , 'checked' => $admin->sup_report_edit, 'name' => 'sup_report_edit'],
            (object)[ 'tag' => "Add Photos from Reports" , 'checked' => $admin->sup_report_addPhoto, 'name' => 'sup_report_addPhoto'],
            (object)[ 'tag' => "Remove Photos from Reports" , 'checked' => $admin->sup_report_removePhoto, 'name' => 'sup_report_removePhoto'],
            (object)[ 'tag' => "Delete Report" , 'checked' => $admin->sup_report_destroy, 'name' => 'sup_report_destroy'],

            (object)[ 'tag' => "View List Reports" , 'checked' => $admin->tech_report_index, 'name' => 'tech_report_index'],
            (object)[ 'tag' => "Create New Report" , 'checked' => $admin->tech_report_create, 'name' => 'tech_report_create'],
            (object)[ 'tag' => "Show Report Details" , 'checked' => $admin->tech_report_show, 'name' => 'tech_report_show'],
            (object)[ 'tag' => "Edit Reports" , 'checked' => $admin->tech_report_edit, 'name' => 'tech_report_edit'],
            (object)[ 'tag' => "Add Photos from Reports" , 'checked' => $admin->tech_report_addPhoto, 'name' => 'tech_report_addPhoto'],
            (object)[ 'tag' => "Remove Photos from Reports" , 'checked' => $admin->tech_report_removePhoto, 'name' => 'tech_report_removePhoto'],
            (object)[ 'tag' => "Delete Report" , 'checked' => $admin->tech_report_destroy, 'name' => 'tech_report_destroy'],
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
        ];
    }

}
