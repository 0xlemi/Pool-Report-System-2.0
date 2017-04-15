<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\UserRoleCompany;

class VerificationToken extends Model
{
    protected $fillable = ['token'];

    public function getRouteKeyName()
    {
        return 'token';
    }

    // *******************
    //   Relationships
    // *******************

    public function userRoleCompany()
    {
        return $this->belongsTo(UserRoleCompany::class);
    }

}
