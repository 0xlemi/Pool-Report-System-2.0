<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get reports associatod with this user
     */
    public function reports(){
        return $this->hasManyThrough('App\Report', 'App\Service');
    }

    /**
     *  Get services associated with this user
     * 
     */
    public function services(){
        return $this->hasMany('App\Service');
    }

    // public function clients(){
    //     return $this->belongsToManyThrough('App\Client', 'App\Service');
    // }

    /**
     *  Get supervisors assaciated with this user
     * 
     */
    public function supervisors(){
        return $this->hasMany('App\Supervisor');
    }
    
    /**
     * Get technicians assaciated with this user
     */
    public function technicians(){
        return $this->hasManyThrough('App\Technician', 'App\Supervisor');
    }

}
