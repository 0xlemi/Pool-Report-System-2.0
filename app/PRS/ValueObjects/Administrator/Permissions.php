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
        foreach ($this->permissions as $key => $value) {
            $explode =explode('_', $key);
            // check the user
            if($explode[0] == $user){
                if($object){
                    // if Object is set return permissions that relate to the object
                    if($object == $explode[1]){
                        $result[] = (object) array_merge((array)$value, ['name' => $key]);
                    }
                // if Object is null return all
                }else{
                    $result[] = (object) array_merge((array)$value, ['name' => $key]);
                }
            }
        }
        return $result;
    }

    // Get all the premissions and tags from the admin
    protected function buildPermissions(Administrator $admin)
    {
        return (object)[
            // Report
            'sup_report_index' => (object)[ 'tag' => "View List Reports" , 'checked' => $admin->sup_report_index],
            'sup_report_create' => (object)[ 'tag' => "Create New Report" , 'checked' => $admin->sup_report_create],
            'sup_report_show' => (object)[ 'tag' => "Show Report Details" , 'checked' => $admin->sup_report_show],
            'sup_report_edit' => (object)[ 'tag' => "Edit Reports" , 'checked' => $admin->sup_report_edit],
            'sup_report_addPhoto' => (object)[ 'tag' => "Add Photos from Reports" , 'checked' => $admin->sup_report_addPhoto],
            'sup_report_removePhoto' => (object)[ 'tag' => "Remove Photos from Reports" , 'checked' => $admin->sup_report_removePhoto],
            'sup_report_destroy' => (object)[ 'tag' => "Delete Report" , 'checked' => $admin->sup_report_destroy],

            'tech_report_index' => (object)[ 'tag' => "View List Reports" , 'checked' => $admin->tech_report_index],
            'tech_report_create' => (object)[ 'tag' => "Create New Report" , 'checked' => $admin->tech_report_create],
            'tech_report_show' => (object)[ 'tag' => "Show Report Details" , 'checked' => $admin->tech_report_show],
            'tech_report_edit' => (object)[ 'tag' => "Edit Reports" , 'checked' => $admin->tech_report_edit],
            'tech_report_addPhoto' => (object)[ 'tag' => "Add Photos from Reports" , 'checked' => $admin->tech_report_addPhoto],
            'tech_report_removePhoto' => (object)[ 'tag' => "Remove Photos from Reports" , 'checked' => $admin->tech_report_removePhoto],
            'tech_report_destroy' => (object)[ 'tag' => "Delete Report" , 'checked' => $admin->tech_report_destroy],
            // Service
            'sup_service_index' => (object)[ 'tag' => "View List Services" , 'checked' => $admin->sup_service_index],
            'sup_service_create' => (object)[ 'tag' => "Create New Service" , 'checked' => $admin->sup_service_create],
            'sup_service_show' => (object)[ 'tag' => "Show Service Details" , 'checked' => $admin->sup_service_show],
            'sup_service_edit' => (object)[ 'tag' => "Edit Services" , 'checked' => $admin->sup_service_edit],
            'sup_service_destroy' => (object)[ 'tag' => "Delete Service" , 'checked' => $admin->sup_service_destroy],

            'tech_service_index' => (object)[ 'tag' => "View List Services" , 'checked' => $admin->tech_service_index],
            'tech_service_create' => (object)[ 'tag' => "Create New Service" , 'checked' => $admin->tech_service_create],
            'tech_service_show' => (object)[ 'tag' => "Show Service Details" , 'checked' => $admin->tech_service_show],
            'tech_service_edit' => (object)[ 'tag' => "Edit Services" , 'checked' => $admin->tech_service_edit],
            // Client
            'sup_client_index' => (object)[ 'tag' => "View List Clients", 'checked' => $admin->sup_client_index],
            'sup_client_create' => (object)[ 'tag' => "Create New Client" , 'checked' => $admin->sup_client_create],
            'sup_client_show' => (object)[ 'tag' => "Show Client Details" , 'checked' => $admin->sup_client_show],
            'sup_client_edit' => (object)[ 'tag' => "Edit Clients" , 'checked' => $admin->sup_client_edit],
            'sup_client_destroy' => (object)[ 'tag' => "Delete Client" , 'checked' => $admin->sup_client_destroy],

            'tech_client_index' => (object)[ 'tag' => "View List Clients" , 'checked' => $admin->tech_client_index],
            'tech_client_show' => (object)[ 'tag' => "Show Client Details" , 'checked' => $admin->tech_client_show],
            // Supervisor
            'sup_supervisor_index' => (object)[ 'tag' => "View List Supervisors", 'checked' => $admin->sup_supervisor_index],
            'sup_supervisor_create' => (object)[ 'tag' => "Create New Supervisor" , 'checked' => $admin->sup_supervisor_create],
            'sup_supervisor_show' => (object)[ 'tag' => "Show Supervisor Details" , 'checked' => $admin->sup_supervisor_show],
            'sup_supervisor_edit' => (object)[ 'tag' => "Edit Supervisors" , 'checked' => $admin->sup_supervisor_edit],
            'sup_supervisor_destroy' => (object)[ 'tag' => "Delete Supervisor" , 'checked' => $admin->sup_supervisor_destroy],

            'tech_supervisor_index' => (object)[ 'tag' => "View List Supervisors" , 'checked' => $admin->tech_supervisor_index],
            'tech_supervisor_show' => (object)[ 'tag' => "Show Supervisor Details" , 'checked' => $admin->tech_supervisor_show],
            // Technician
            'sup_technician_index' => (object)[ 'tag' => "View List Technicians", 'checked' => $admin->sup_technician_index],
            'sup_technician_create' => (object)[ 'tag' => "Create New Technician" , 'checked' => $admin->sup_technician_create],
            'sup_technician_show' => (object)[ 'tag' => "Show Technician Details" , 'checked' => $admin->sup_technician_show],
            'sup_technician_edit' => (object)[ 'tag' => "Edit Technicians" , 'checked' => $admin->sup_technician_edit],
            'sup_technician_destroy' => (object)[ 'tag' => "Delete Technician" , 'checked' => $admin->sup_technician_destroy],

            'tech_technician_index' => (object)[ 'tag' => "View List Technicians" , 'checked' => $admin->tech_technician_index],
            'tech_technician_show' => (object)[ 'tag' => "Show Technician Details" , 'checked' => $admin->tech_technician_show],
        ];
    }

}
