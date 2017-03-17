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
        return [
            'name' => $admin->name,
            'email' => $admin->user->email,
            'companyName' => $admin->company_name,
            'website' => $admin->website,
            'facebook' => $admin->facebook,
            'twitter' => $admin->twitter,
            'notification_settings' => [
                $admin->user->notificationSettings->getAll()
            ],
            'permissions' => $admin->permissions()->getAll(),
        ];

    }

}
