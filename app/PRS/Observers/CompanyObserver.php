<?php

namespace App\PRS\Observers;

use App\Company;
use DB;

class CompanyObserver
{



    /**
     * Listen to the App\Company deleting event.
     *
     * @param  App\Company  $company
     * @return void
     */
    public function deleting(Company $company)
    {
        // Cancel Stripe Subscription
        if ($company->subscribed('main')) {
            $company->subscription('main')->cancelNow();
        }

        // Delete associated objects
        foreach ($company->userRoleCompanies() as $person) {
            $person->delete();
        }
        foreach ($company->services as $service) {
            $service->delete();
        }
        foreach ($company->permissionRoleCompanies as $permissionRoleCompany) {
            $permissionRoleCompany->delete();
        }
    }

    /**
     * Listen to the App\Company deleting event.
     *
     * @param  App\Company  $company
     * @return void
     */
    public function deleted(Company $company)
    {
        dispatch(new DeleteImagesFromS3($company->images));
    }

        public function created(Company $company)
    {
        DB::table('permission_role_company')->insert([
            // Supervisor
            ['role_id' => 3, 'permission_id' => 1, 'company_id' => $company->id],// Show Reports
            ['role_id' => 3, 'permission_id' => 2, 'company_id' => $company->id],// Create New Report
            ['role_id' => 3, 'permission_id' => 3, 'company_id' => $company->id],// Edit Reports
            ['role_id' => 3, 'permission_id' => 4, 'company_id' => $company->id],// Add Photos for Reports
            ['role_id' => 3, 'permission_id' => 5, 'company_id' => $company->id],// Remove Photos for Reports
            ['role_id' => 3, 'permission_id' => 6, 'company_id' => $company->id],// Delete Report
            ['role_id' => 3, 'permission_id' => 7, 'company_id' => $company->id],// Show Work Orders
            ['role_id' => 3, 'permission_id' => 8, 'company_id' => $company->id],// Create New Work Order
            ['role_id' => 3, 'permission_id' => 9, 'company_id' => $company->id],// Edit Work Orders
            ['role_id' => 3 ,'permission_id' => 10, 'company_id' => $company->id ],// Finish Work Orders
            ['role_id' => 3 ,'permission_id' => 11, 'company_id' => $company->id ],// Add Before Photos for Work Orders
            ['role_id' => 3 ,'permission_id' => 12, 'company_id' => $company->id ],// Remove Photos for Work Orders
            ['role_id' => 3 ,'permission_id' => 13, 'company_id' => $company->id ],// Delete Work Orders
            ['role_id' => 3 ,'permission_id' => 14, 'company_id' => $company->id ],// Show Works
            ['role_id' => 3 ,'permission_id' => 15, 'company_id' => $company->id ],// Create New Work
            ['role_id' => 3 ,'permission_id' => 16, 'company_id' => $company->id ],// Edit Work
            ['role_id' => 3 ,'permission_id' => 17, 'company_id' => $company->id ],// Add Before Photos for Work
            ['role_id' => 3 ,'permission_id' => 18, 'company_id' => $company->id ],// Remove Before Photos for Work
            ['role_id' => 3 ,'permission_id' => 19, 'company_id' => $company->id ],// Delete Work
            ['role_id' => 3 ,'permission_id' => 20, 'company_id' => $company->id ],// Show Services
            ['role_id' => 3 ,'permission_id' => 21, 'company_id' => $company->id ],// Create New Service
            ['role_id' => 3 ,'permission_id' => 22, 'company_id' => $company->id ],// Edit Services
            ['role_id' => 3 ,'permission_id' => 23, 'company_id' => $company->id ],// Delete Service
            ['role_id' => 3 ,'permission_id' => 24, 'company_id' => $company->id ],// Show Contract
            ['role_id' => 3 ,'permission_id' => 25, 'company_id' => $company->id ],// Create New Contract
            ['role_id' => 3 ,'permission_id' => 26, 'company_id' => $company->id ],// Edit Contract
            ['role_id' => 3 ,'permission_id' => 27, 'company_id' => $company->id ],// Toggle Contract Activation
            ['role_id' => 3 ,'permission_id' => 29, 'company_id' => $company->id ],// Show Measurements
            ['role_id' => 3 ,'permission_id' => 30, 'company_id' => $company->id ],// Create New Measurement
            ['role_id' => 3 ,'permission_id' => 31, 'company_id' => $company->id ],// Edit Measurements
            ['role_id' => 3 ,'permission_id' => 32, 'company_id' => $company->id ],// Delete Measurement
            ['role_id' => 3 ,'permission_id' => 33, 'company_id' => $company->id ],// Show Equipment
            ['role_id' => 3 ,'permission_id' => 34, 'company_id' => $company->id ],// Create New Equipment
            ['role_id' => 3 ,'permission_id' => 35, 'company_id' => $company->id ],// Edit Equipment
            ['role_id' => 3 ,'permission_id' => 36, 'company_id' => $company->id ],// Add Photos for Equipment
            ['role_id' => 3 ,'permission_id' => 37, 'company_id' => $company->id ],// Remove Photos for Equipment
            ['role_id' => 3 ,'permission_id' => 38, 'company_id' => $company->id ],// Delete Equipment
            ['role_id' => 3 ,'permission_id' => 39, 'company_id' => $company->id ],// Show Clients
            ['role_id' => 3 ,'permission_id' => 40, 'company_id' => $company->id ],// Create New Client
            ['role_id' => 3 ,'permission_id' => 41, 'company_id' => $company->id ],// Edit Clients
            ['role_id' => 3 ,'permission_id' => 42, 'company_id' => $company->id ],// Delete Client
            ['role_id' => 3 ,'permission_id' => 43, 'company_id' => $company->id ],// Show Supervisor
            ['role_id' => 3 ,'permission_id' => 44, 'company_id' => $company->id ],// Create New Supervisor
            ['role_id' => 3 ,'permission_id' => 47, 'company_id' => $company->id ],// Show Technicians
            ['role_id' => 3 ,'permission_id' => 48, 'company_id' => $company->id ],// Create New Technician
            ['role_id' => 3 ,'permission_id' => 49, 'company_id' => $company->id ],// Edit Technicians
            ['role_id' => 3 ,'permission_id' => 50, 'company_id' => $company->id ],// Delete Technician
            ['role_id' => 3 ,'permission_id' => 51, 'company_id' => $company->id ],// Show Invoices
            ['role_id' => 3 ,'permission_id' => 53, 'company_id' => $company->id ],// Create New Payment
            ['role_id' => 3 ,'permission_id' => 54, 'company_id' => $company->id ],// Show Payments

            // Technician
            ['role_id' => 4, 'permission_id' => 1, 'company_id' => $company->id],// Show Reports
            ['role_id' => 4, 'permission_id' => 2, 'company_id' => $company->id],// Create New Report
            ['role_id' => 4, 'permission_id' => 7, 'company_id' => $company->id],// Show Work Orders
            ['role_id' => 4, 'permission_id' => 8, 'company_id' => $company->id],// Create New Work Order
            ['role_id' => 4 ,'permission_id' => 10, 'company_id' => $company->id ],// Finish Work Orders
            ['role_id' => 4 ,'permission_id' => 14, 'company_id' => $company->id ],// Show Works
            ['role_id' => 4 ,'permission_id' => 15, 'company_id' => $company->id ],// Create New Work
            ['role_id' => 4 ,'permission_id' => 17, 'company_id' => $company->id ],// Add Before Photos for Work
            ['role_id' => 4 ,'permission_id' => 20, 'company_id' => $company->id ],// Show Services
            ['role_id' => 4 ,'permission_id' => 29, 'company_id' => $company->id ],// Show Measurements
            ['role_id' => 4 ,'permission_id' => 30, 'company_id' => $company->id ],// Create New Measurement
            ['role_id' => 4 ,'permission_id' => 33, 'company_id' => $company->id ],// Show Equipment
            ['role_id' => 4 ,'permission_id' => 34, 'company_id' => $company->id ],// Create New Equipment
            ['role_id' => 4 ,'permission_id' => 36, 'company_id' => $company->id ],// Add Photos for Equipment
            ['role_id' => 4 ,'permission_id' => 43, 'company_id' => $company->id ],// Show Supervisor
        ]);

    }

}
