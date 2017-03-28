<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Work;
use App\Report;
use App\Role;
use App\User;
use App\Company;
use App\WorkOrder;
use App\UrlSigner;
use App\NotificationSetting;

class UserRoleCompany extends Model
{


    public function isRole($role)
    {
        return ($this->role->name == $role);
    }

    public function hasNotificationSetting($name)
    {
        return $this->notificationSettings->contains($name);
    }

    // **********************
    //     RELATIONSHIPS
    // **********************

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function reports()
    {
    	return $this->hasMany(Report::class);
    }

    public function workOrders()
    {
    	return $this->hasMany(WorkOrder::class);
    }

    public function works()
    {
    	return $this->hasMany(Work::class);
    }

    public function notificationSettings()
    {
        return $this->belongsToMany(NotificationSetting::class , 'urc_notify_setting', 'urc_id', 'notify_setting_id');
    }

    public function urlSigners()
    {
        return $this->hasMany(UrlSigner::class);
    }



}
