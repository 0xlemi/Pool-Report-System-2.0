<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Company;
use App\Permission;
use App\UserRoleCompany;

class Role extends Model
{


    // ***********************
    //     Relationships
    // ***********************

    public function permissionsFromCompany(Company $company)
    {
        $this->permissions()->where('company_id', $company->id);
    }

    // basic relationships

    public function userRoleCompanies()
    {
        return $this->hasMany(UserRoleCompany::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role_company');
    }
}
