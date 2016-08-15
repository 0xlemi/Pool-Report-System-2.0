<?php

namespace App\PRS\Transformers;
use App\Administrator;



/**
 * Transformer for the administrator class
 */
class AdministratorTransformer extends Transformer
{

    public function transform(Administrator $admin, $withPermissions = false)
    {

        $photo = 'no image';
        if($admin->imageExists()){
            // $photo = $this->imageTransformer->transform($admin->image(1, false));
        }

        $adminInfo = [
            'name' => $admin->name,
            'email' => $admin->user()->email,
            'companyName' => $admin->company_name,
            'website' => $admin->website,
            'facebook' => $admin->facebook,
            'twitter' => $admin->twitter,
            'getReportsEmails' => $admin->get_reports_emails,
            'photo' => $photo,
        ];
        $permissions = [
                'permissions' => [
                'sup_report_index' => $admin->sup_report_index,
                'sup_report_create' => $admin->sup_report_create,
                'sup_report_show' => $admin->sup_report_show,
                'sup_report_edit' => $admin->sup_report_edit,
                'sup_report_addPhoto' => $admin->sup_report_addPhoto,
                'sup_report_removePhoto' => $admin->sup_report_removePhoto,
                'sup_report_destroy' => $admin->sup_report_destroy,
                'tech_report_index' => $admin->tech_report_index,
                'tech_report_create' => $admin->tech_report_create,
                'tech_report_show' => $admin->tech_report_show,
                'tech_report_edit' => $admin->tech_report_edit,
                'tech_report_addPhoto' => $admin->tech_report_addPhoto,
                'tech_report_removePhoto' => $admin->tech_report_removePhoto,
                'tech_report_destroy' => $admin->tech_report_destroy,
                // Services
                'sup_service_index' => $admin->sup_service_index,
                'sup_service_create' => $admin->sup_service_create,
                'sup_service_show' => $admin->sup_service_show,
                'sup_service_edit' => $admin->sup_service_edit,
                'sup_service_destroy' => $admin->sup_service_destroy,
                'tech_service_index' => $admin->tech_service_index,
                'tech_service_create' => $admin->tech_service_create,
                'tech_service_show' => $admin->tech_service_show,
                'tech_service_edit' => $admin->tech_service_edit,
                'tech_service_destroy' => $admin->tech_service_destroy,
                // Client
                'sup_client_index' => $admin->sup_client_index,
                'sup_client_create' => $admin->sup_client_create,
                'sup_client_show' => $admin->sup_client_show,
                'sup_client_edit' => $admin->sup_client_edit,
                'sup_client_destroy' => $admin->sup_client_destroy,
                'tech_client_index' => $admin->tech_client_index,
                'tech_client_create' => $admin->tech_client_create,
                'tech_client_show' => $admin->tech_client_show,
                'tech_client_edit' => $admin->tech_client_edit,
                'tech_client_destroy' => $admin->tech_client_destroy,
                // Supervisors
                'sup_supervisor_index' => $admin->sup_supervisor_index,
                'sup_supervisor_create' => $admin->sup_supervisor_create,
                'sup_supervisor_show' => $admin->sup_supervisor_show,
                'sup_supervisor_edit' => $admin->sup_supervisor_edit,
                'sup_supervisor_destroy' => $admin->sup_supervisor_destroy,
                'tech_supervisor_index' => $admin->tech_supervisor_index,
                'tech_supervisor_create' => $admin->tech_supervisor_create,
                'tech_supervisor_show' => $admin->tech_supervisor_show,
                'tech_supervisor_edit' => $admin->tech_supervisor_edit,
                'tech_supervisor_destroy' => $admin->tech_supervisor_destroy,
                // Technicians
                'sup_technician_index' => $admin->sup_technician_index,
                'sup_technician_create' => $admin->sup_technician_create,
                'sup_technician_show' => $admin->sup_technician_show,
                'sup_technician_edit' => $admin->sup_technician_edit,
                'sup_technician_destroy' => $admin->sup_technician_destroy,
                'tech_technician_index' => $admin->tech_technician_index,
                'tech_technician_create' => $admin->tech_technician_create,
                'tech_technician_show' => $admin->tech_technician_show,
                'tech_technician_edit' => $admin->tech_technician_edit,
                'tech_technician_destroy' => $admin->tech_technician_destroy,
            ],
        ];
        if($withPermissions){
            return array_merge($adminInfo, $permissions);
        }
        return $adminInfo;
    }

}
