<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Role;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
