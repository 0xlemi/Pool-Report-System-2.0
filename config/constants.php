<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom Constants for Pool Report System
    |--------------------------------------------------------------------------
    */

    'currencies' => [
        'USD',
        'MXN',
        'CAD',
        'EUR',
    ],

    'languages' => [
        'en',
        'es'
    ],

    'timezones' =>  DateTimeZone::listIdentifiers(DateTimeZone::ALL),

    'startLocation' => [
        'latitude' => '23.0446032',
        'longitude' => '-109.705866',
    ],

    'notificationTypes' => [
        'database',
        'mail'    
    ],

    'notifications' => [
        'notify_report_created' => "Report is Created",
    ],

    'permissions' => [
        'sup_report_view' => "Show Reports",
        'sup_report_create' => "Create New Report",
        'sup_report_update' => "Edit Reports",
        'sup_report_addPhoto' => "Add Photos for Reports",
        'sup_report_removePhoto' => "Remove Photos for Reports",
        'sup_report_delete' => "Delete Report",
        'tech_report_view' => "Show Reports",
        'tech_report_create' => "Create New Report",
        'tech_report_update' => "Edit Reports",
        'tech_report_addPhoto' => "Add Photos for Reports",
        'tech_report_removePhoto' => "Remove Photos for Reports",
        'tech_report_delete' => "Delete Report",

        'sup_workorder_view' => "Show Work Orders",
        'sup_workorder_create' => "Create New Work Order",
        'sup_workorder_update' => "Edit Work Orders",
        'sup_workorder_finish' => "Finish Work Orders",
        'sup_workorder_addPhoto' => "Add Before Photos for Work Orders",
        'sup_workorder_removePhoto' => "Remove Photos for Work Orders",
        'sup_workorder_delete' => "Delete Work Orders",
        'tech_workorder_view' => "Show Work Orders",
        'tech_workorder_create' => "Create New Work Order",
        'tech_workorder_update' => "Edit Work Orders",
        'tech_workorder_finish' => "Finish Work Orders",
        'tech_workorder_addPhoto' => "Add Before Photos for Work Orders",
        'tech_workorder_removePhoto' => "Remove Photos for Work Orders",

        'sup_work_view' => "Show Works",
        'sup_work_create' => "Create New Work",
        'sup_work_update' => "Edit Work",
        'sup_work_addPhoto' => "Add Before Photos for Work",
        'sup_work_removePhoto' => "Remove Before Photos for Work",
        'sup_work_delete' => "Delete Work",
        'tech_work_view' => "Show Works",
        'tech_work_create' => "Create New Work",
        'tech_work_update' => "Edit Work",
        'tech_work_addPhoto' => "Add Before Photos for Work",
        'tech_work_removePhoto' => "Remove Before Photos for Work",
        'tech_work_delete' => "Delete Work",

        'sup_service_view' => "Show Services",
        'sup_service_create' => "Create New Service",
        'sup_service_update' => "Edit Services",
        'sup_service_delete' => "Delete Service",
        'tech_service_view' => "Show Services",
        'tech_service_create' => "Create New Service",
        'tech_service_update' => "Edit Services",

        'sup_contract_view' => "Show Contract",
        'sup_contract_create' => "Create New Contract",
        'sup_contract_update' => "Edit Contract",
        'sup_contract_deactivate' => "Toggle Contract Activation",
        'sup_contract_delete' => "Delete Contract",
        'tech_contract_view' => "Show Contract",
        'tech_contract_create' => "Create New Contract",
        'tech_contract_update' => "Edit Contract",
        'tech_contract_deactivate' => "Toggle Contract Activation",
        'tech_contract_delete' => "Delete Contract",

        'sup_chemical_view' => "Show Chemicals",
        'sup_chemical_create' => "Create New Chemical",
        'sup_chemical_update' => "Edit Chemicals",
        'sup_chemical_delete' => "Delete Chemical",
        'tech_chemical_view' => "Show Chemicals",
        'tech_chemical_create' => "Create New Chemical",
        'tech_chemical_update' => "Edit Chemicals",
        'tech_chemical_delete' => "Delete Chemical",

        'sup_equipment_view' => "Show Equipment",
        'sup_equipment_create' => "Create New Equipment",
        'sup_equipment_update' => "Edit Equipment",
        'sup_equipment_addPhoto' => "Add Photos for Equipment",
        'sup_equipment_removePhoto' => "Remove Photos for Equipment",
        'sup_equipment_delete' => "Delete Equipment",
        'tech_equipment_view' => "Show Equipment",
        'tech_equipment_create' => "Create New Equipment",
        'tech_equipment_update' => "Edit Equipment",
        'tech_equipment_addPhoto' => "Add Photos for Equipment",
        'tech_equipment_removePhoto' => "Remove Photos for Equipment",
        'tech_equipment_delete' => "Delete Equipment",

        'sup_client_view' => "Show Clients",
        'sup_client_create' => "Create New Client",
        'sup_client_update' => "Edit Clients",
        'sup_client_delete' => "Delete Client",
        'tech_client_view' => "Show Clients",

        'sup_supervisor_view' => "Show Supervisor",
        'sup_supervisor_create' => "Create New Supervisor",
        'sup_supervisor_update' => "Edit Supervisors",
        'sup_supervisor_delete' => "Delete Supervisor",
        'tech_supervisor_view' => "Show Supervisor",

        'sup_technician_view' => "Show Technicians",
        'sup_technician_create' => "Create New Technician",
        'sup_technician_update' => "Edit Technicians",
        'sup_technician_delete' => "Delete Technician",
        'tech_technician_view' => "Show Technicians",

        'sup_invoice_view' => "Show Invoices",
        'sup_invoice_delete' => "Delete Inovices",
        'tech_invoice_view' => "Show Invoices",

        'sup_payment_view' => "Create New Payment",
        'sup_payment_create' => "Show Payments",
        'sup_payment_delete' => "Delete Inovices",
        'tech_payment_view' => "Create New Payment",
        'tech_payment_create' => "Show Payments",
    ],

];
