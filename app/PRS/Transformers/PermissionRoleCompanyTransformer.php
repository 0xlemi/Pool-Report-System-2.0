<?php

namespace App\PRS\Transformers;

use App\PermissionRoleCompany;
use App\PRS\Transformers\RoleTransformer;
use App\PRS\Transformers\PermissionTransformer;


/**
 * Transformer for the report class
 */
class PermissionRoleCompanyTransformer extends Transformer
{

    private $roleTransformer;
    private $permissionTransformer;

    public function __construct(RoleTransformer $roleTransformer, PermissionTransformer $permissionTransformer)
    {
        $this->roleTransformer = $roleTransformer;
        $this->permissionTransformer = $permissionTransformer;
    }


    /**
     * Transform PermissionRoleCompany to api friendly array
     * @param  PermissionRoleCompany $permissionRoleCompany
     * @return array
     */
    public function transform(PermissionRoleCompany $permissionRoleCompany)
    {
        return [
            'permission' => $this->permissionTransformer->transform($permissionRoleCompany->permission),
            'role' => $this->roleTransformer->transform($permissionRoleCompany->role),
        ];
    }
}
