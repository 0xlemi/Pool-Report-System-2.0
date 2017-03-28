<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\UserRoleCompany;

class ActivationToken extends Model
{
    protected $fillable = ['token'];

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function userRoleCompany()
    {
        return $this->belongsTo(UserRoleCompany::class);
    }

}
