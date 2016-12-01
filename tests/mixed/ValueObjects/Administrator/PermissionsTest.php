<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Administrator;
use App\PRS\ValueObjects\Administrator\Permissions;

class PermissionsTest extends DatabaseTester
{

    /** @test */
    public function it_gets_technicians_all_permissions()
    {
        // Given
        $admin = $this->createAdministrator();

        // When
        $permissions =  new Permissions($admin);
        $allTechnicianPermissions = $permissions->technician();

        // Then
        $this->assertEquals($allTechnicianPermissions, [
            // Report
            (object)[ 'tag' => "View List Reports" , 'checked' => 1, 'name' => 'tech_report_index'],
            (object)[ 'tag' => "Create New Report" , 'checked' => 1, 'name' => 'tech_report_create'],
            (object)[ 'tag' => "Show Report Details" , 'checked' => 1, 'name' => 'tech_report_show'],
            (object)[ 'tag' => "Edit Reports" , 'checked' => 0, 'name' => 'tech_report_edit'],
            (object)[ 'tag' => "Add Photos from Reports" , 'checked' => 0, 'name' => 'tech_report_addPhoto'],
            (object)[ 'tag' => "Remove Photos from Reports" , 'checked' => 0, 'name' => 'tech_report_removePhoto'],
            (object)[ 'tag' => "Delete Report" , 'checked' => 0, 'name' => 'tech_report_destroy'],
            // Service
            (object)[ 'tag' => "View List Services" , 'checked' => 1, 'name' => 'tech_service_index'],
            (object)[ 'tag' => "Create New Service" , 'checked' => 0, 'name' => 'tech_service_create'],
            (object)[ 'tag' => "Show Service Details" , 'checked' => 1, 'name' => 'tech_service_show'],
            (object)[ 'tag' => "Edit Services" , 'checked' => 0, 'name' => 'tech_service_edit'],
            // Client
            (object)[ 'tag' => "View List Clients" , 'checked' => 0, 'name' => 'tech_client_index'],
            (object)[ 'tag' => "Show Client Details" , 'checked' => 0, 'name' => 'tech_client_show'],
            // Supervisor
            (object)[ 'tag' => "View List Supervisors" , 'checked' => 1, 'name' => 'tech_supervisor_index'],
            (object)[ 'tag' => "Show Supervisor Details" , 'checked' => 0, 'name' => 'tech_supervisor_show'],
            // Technician
            (object)[ 'tag' => "View List Technicians" , 'checked' => 1, 'name' => 'tech_technician_index'],
            (object)[ 'tag' => "Show Technician Details" , 'checked' => 0, 'name' => 'tech_technician_show'],

        ]);
    }

    /** @test */
    public function it_gets_technicians_reports_permissions()
    {
        // Given
        $admin = $this->createAdministrator();

        // When
        $permissions =  new Permissions($admin);
        $allTechnicianPermissions = $permissions->technician('report');

        // Then
        $this->assertEquals($allTechnicianPermissions, [
            (object)[ 'tag' => "View List Reports" , 'checked' => 1, 'name' => 'tech_report_index'],
            (object)[ 'tag' => "Create New Report" , 'checked' => 1, 'name' => 'tech_report_create'],
            (object)[ 'tag' => "Show Report Details" , 'checked' => 1, 'name' => 'tech_report_show'],
            (object)[ 'tag' => "Edit Reports" , 'checked' => 0, 'name' => 'tech_report_edit'],
            (object)[ 'tag' => "Add Photos from Reports" , 'checked' => 0, 'name' => 'tech_report_addPhoto'],
            (object)[ 'tag' => "Remove Photos from Reports" , 'checked' => 0, 'name' => 'tech_report_removePhoto'],
            (object)[ 'tag' => "Delete Report" , 'checked' => 0, 'name' => 'tech_report_destroy'],
        ]);

    }

    /** @test */
    public function it_gets_supervisors_all_permissions()
    {
        // Given
        $admin = $this->createAdministrator();

        // When
        $permissions =  new Permissions($admin);
        $allSupervisorPermissions = $permissions->supervisor();

        // Then
        $this->assertEquals($allSupervisorPermissions, [
            // Report
            (object)[ 'tag' => "View List Reports" , 'checked' => 1, 'name' => 'sup_report_index'],
            (object)[ 'tag' => "Create New Report" , 'checked' => 1, 'name' => 'sup_report_create'],
            (object)[ 'tag' => "Show Report Details" , 'checked' => 1, 'name' => 'sup_report_show'],
            (object)[ 'tag' => "Edit Reports" , 'checked' => 1, 'name' => 'sup_report_edit'],
            (object)[ 'tag' => "Add Photos from Reports" , 'checked' => 1, 'name' => 'sup_report_addPhoto'],
            (object)[ 'tag' => "Remove Photos from Reports" , 'checked' => 1, 'name' => 'sup_report_removePhoto'],
            (object)[ 'tag' => "Delete Report" , 'checked' => 1, 'name' => 'sup_report_destroy'],
            // Service
            (object)[ 'tag' => "View List Services" , 'checked' => 1, 'name' => 'sup_service_index'],
            (object)[ 'tag' => "Create New Service" , 'checked' => 1, 'name' => 'sup_service_create'],
            (object)[ 'tag' => "Show Service Details" , 'checked' => 1, 'name' => 'sup_service_show'],
            (object)[ 'tag' => "Edit Services" , 'checked' => 1, 'name' => 'sup_service_edit'],
            (object)[ 'tag' => "Delete Service" , 'checked' => 1, 'name' => 'sup_service_destroy'],
            // Client
            (object)[ 'tag' => "View List Clients", 'checked' => 1, 'name' => 'sup_client_index'],
            (object)[ 'tag' => "Create New Client" , 'checked' => 1, 'name' => 'sup_client_create'],
            (object)[ 'tag' => "Show Client Details" , 'checked' => 1, 'name' => 'sup_client_show'],
            (object)[ 'tag' => "Edit Clients" , 'checked' => 1, 'name' => 'sup_client_edit'],
            (object)[ 'tag' => "Delete Client" , 'checked' => 1, 'name' => 'sup_client_destroy'],
            // Supervisor
            (object)[ 'tag' => "View List Supervisors", 'checked' => 1, 'name' => 'sup_supervisor_index'],
            (object)[ 'tag' => "Create New Supervisor" , 'checked' => 1, 'name' => 'sup_supervisor_create'],
            (object)[ 'tag' => "Show Supervisor Details" , 'checked' => 1, 'name' => 'sup_supervisor_show'],
            (object)[ 'tag' => "Edit Supervisors" , 'checked' => 0, 'name' => 'sup_supervisor_edit'],
            (object)[ 'tag' => "Delete Supervisor" , 'checked' => 0, 'name' => 'sup_supervisor_destroy'],
            // Technician
            (object)[ 'tag' => "View List Technicians", 'checked' => 1, 'name' => 'sup_technician_index'],
            (object)[ 'tag' => "Create New Technician" , 'checked' => 1, 'name' => 'sup_technician_create'],
            (object)[ 'tag' => "Show Technician Details" , 'checked' => 1, 'name' => 'sup_technician_show'],
            (object)[ 'tag' => "Edit Technicians" , 'checked' => 1, 'name' => 'sup_technician_edit'],
            (object)[ 'tag' => "Delete Technician" , 'checked' => 1, 'name' => 'sup_technician_destroy'],
        ]);
    }

    /** @test */
    public function it_gets_supervisors_technician_permissions()
    {
        // Given
        $admin = $this->createAdministrator();

        // When
        $permissions =  new Permissions($admin);
        $allTechnicianPermissions = $permissions->supervisor('technician');

        // Then
        $this->assertEquals($allTechnicianPermissions, [
            (object)[ 'tag' => "View List Technicians", 'checked' => 1, 'name' => 'sup_technician_index'],
            (object)[ 'tag' => "Create New Technician" , 'checked' => 1, 'name' => 'sup_technician_create'],
            (object)[ 'tag' => "Show Technician Details" , 'checked' => 1, 'name' => 'sup_technician_show'],
            (object)[ 'tag' => "Edit Technicians" , 'checked' => 1, 'name' => 'sup_technician_edit'],
            (object)[ 'tag' => "Delete Technician" , 'checked' => 1, 'name' => 'sup_technician_destroy'],
        ]);

    }

    /** @test */
    public function it_gets_technician_permissions_divided()
    {
        // Given
        $admin = $this->createAdministrator();

        // When
        $permissions =  new Permissions($admin);
        $allTechnicianPermissions = $permissions->permissionsDivided('tech');

        // Then
        $this->assertEquals($allTechnicianPermissions, [
            'report' => [
                (object)[ 'tag' => "View List Reports" , 'checked' => 1, 'name' => 'tech_report_index'],
                (object)[ 'tag' => "Create New Report" , 'checked' => 1, 'name' => 'tech_report_create'],
                (object)[ 'tag' => "Show Report Details" , 'checked' => 1, 'name' => 'tech_report_show'],
                (object)[ 'tag' => "Edit Reports" , 'checked' => 0, 'name' => 'tech_report_edit'],
                (object)[ 'tag' => "Add Photos from Reports" , 'checked' => 0, 'name' => 'tech_report_addPhoto'],
                (object)[ 'tag' => "Remove Photos from Reports" , 'checked' => 0, 'name' => 'tech_report_removePhoto'],
                (object)[ 'tag' => "Delete Report" , 'checked' => 0, 'name' => 'tech_report_destroy'],
            ],
            'service' => [
                (object)[ 'tag' => "View List Services" , 'checked' => 1, 'name' => 'tech_service_index'],
                (object)[ 'tag' => "Create New Service" , 'checked' => 0, 'name' => 'tech_service_create'],
                (object)[ 'tag' => "Show Service Details" , 'checked' => 1, 'name' => 'tech_service_show'],
                (object)[ 'tag' => "Edit Services" , 'checked' => 0, 'name' => 'tech_service_edit'],
            ],
            'client' => [
                (object)[ 'tag' => "View List Clients" , 'checked' => 0, 'name' => 'tech_client_index'],
                (object)[ 'tag' => "Show Client Details" , 'checked' => 0, 'name' => 'tech_client_show'],
            ],
            'supervisor' => [
                (object)[ 'tag' => "View List Supervisors" , 'checked' => 1, 'name' => 'tech_supervisor_index'],
                (object)[ 'tag' => "Show Supervisor Details" , 'checked' => 0, 'name' => 'tech_supervisor_show'],
            ],
            'technician' => [
                (object)[ 'tag' => "View List Technicians" , 'checked' => 1, 'name' => 'tech_technician_index'],
                (object)[ 'tag' => "Show Technician Details" , 'checked' => 0, 'name' => 'tech_technician_show'],
            ]
        ]);
    }

    /** @test */
    public function it_gets_supervisors_permissions_divided()
    {
        // Given
        $admin = $this->createAdministrator();

        // When
        $permissions =  new Permissions($admin);
        $allSupervisorPermissions = $permissions->permissionsDivided('sup');

        // Then
        $this->assertEquals($allSupervisorPermissions, [
            'report' => [
                (object)[ 'tag' => "View List Reports" , 'checked' => 1, 'name' => 'sup_report_index'],
                (object)[ 'tag' => "Create New Report" , 'checked' => 1, 'name' => 'sup_report_create'],
                (object)[ 'tag' => "Show Report Details" , 'checked' => 1, 'name' => 'sup_report_show'],
                (object)[ 'tag' => "Edit Reports" , 'checked' => 1, 'name' => 'sup_report_edit'],
                (object)[ 'tag' => "Add Photos from Reports" , 'checked' => 1, 'name' => 'sup_report_addPhoto'],
                (object)[ 'tag' => "Remove Photos from Reports" , 'checked' => 1, 'name' => 'sup_report_removePhoto'],
                (object)[ 'tag' => "Delete Report" , 'checked' => 1, 'name' => 'sup_report_destroy'],
            ],
            'service' => [
                (object)[ 'tag' => "View List Services" , 'checked' => 1, 'name' => 'sup_service_index'],
                (object)[ 'tag' => "Create New Service" , 'checked' => 1, 'name' => 'sup_service_create'],
                (object)[ 'tag' => "Show Service Details" , 'checked' => 1, 'name' => 'sup_service_show'],
                (object)[ 'tag' => "Edit Services" , 'checked' => 1, 'name' => 'sup_service_edit'],
                (object)[ 'tag' => "Delete Service" , 'checked' => 1, 'name' => 'sup_service_destroy'],
            ],
            'client' => [
                (object)[ 'tag' => "View List Clients", 'checked' => 1, 'name' => 'sup_client_index'],
                (object)[ 'tag' => "Create New Client" , 'checked' => 1, 'name' => 'sup_client_create'],
                (object)[ 'tag' => "Show Client Details" , 'checked' => 1, 'name' => 'sup_client_show'],
                (object)[ 'tag' => "Edit Clients" , 'checked' => 1, 'name' => 'sup_client_edit'],
                (object)[ 'tag' => "Delete Client" , 'checked' => 1, 'name' => 'sup_client_destroy'],
            ],
            'supervisor' => [
                (object)[ 'tag' => "View List Supervisors", 'checked' => 1, 'name' => 'sup_supervisor_index'],
                (object)[ 'tag' => "Create New Supervisor" , 'checked' => 1, 'name' => 'sup_supervisor_create'],
                (object)[ 'tag' => "Show Supervisor Details" , 'checked' => 1, 'name' => 'sup_supervisor_show'],
                (object)[ 'tag' => "Edit Supervisors" , 'checked' => 0, 'name' => 'sup_supervisor_edit'],
                (object)[ 'tag' => "Delete Supervisor" , 'checked' => 0, 'name' => 'sup_supervisor_destroy'],
            ],
            'technician' => [
                (object)[ 'tag' => "View List Technicians", 'checked' => 1, 'name' => 'sup_technician_index'],
                (object)[ 'tag' => "Create New Technician" , 'checked' => 1, 'name' => 'sup_technician_create'],
                (object)[ 'tag' => "Show Technician Details" , 'checked' => 1, 'name' => 'sup_technician_show'],
                (object)[ 'tag' => "Edit Technicians" , 'checked' => 1, 'name' => 'sup_technician_edit'],
                (object)[ 'tag' => "Delete Technician" , 'checked' => 1, 'name' => 'sup_technician_destroy'],
            ],
        ]);
    }

}
