<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;
use App\Permission;

class PermissionRoleCompany extends Model
{

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'role_id',
        'permission_id'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permission_role_company';

    public function scopeOfRole($query, ...$roles)
    {
        $rolesIds = Role::whereIn('name', $roles)->pluck('id');
        return $query->whereIn('role_id', $rolesIds);
    }

    public function scopePermissions($query)
    {
        $permissionsIds = $query->pluck('permission_id');
        return Permission::whereIn('id', $permissionsIds);
    }

    // ********************
    //    Relationships
    // ********************

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
