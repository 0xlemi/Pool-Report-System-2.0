<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use App\PRS\ValueObjects\All\Type;
use App\PRS\ValueObjects\User\NotificationSettings;
use App\PRS\Helpers\UserHelpers;

use Hash;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'language',
        'userable_id',
        'userable_type',
        'remember_token',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    protected $appends = [
        'fullName'
    ];


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Is this user an administrator ?
     * @return boolean
     * tested
     */
    public function isAdministrator()
    {
        return $this->userable_type == "App\Administrator";
    }

    /**
     * Is this user an client ?
     * @return boolean
     * tested
     */
    public function isClient()
    {
        return $this->userable_type == "App\Client";
    }

    /**
     * Is this user an supervisor ?
     * @return boolean
     * tested
     */
    public function isSupervisor()
    {
        return $this->userable_type == "App\Supervisor";
    }

    /**
     * Is this user an technician ?
     * @return boolean
     * tested
     */
    public function isTechnician()
    {
        return $this->userable_type == "App\Technician";
    }

    public function checkPassword($password)
    {
        return (Hash::check($password, $this->password));
    }

    public function getFullName()
    {
        $object = $this->userable();
        if($this->isAdministrator()){
            return $object->name;
        }
        return $object->name.' '.$object->last_name;
    }

    public function getFullNameAttribute()
    {
        $object = $this->userable();
        if($this->isAdministrator()){
            return $object->name;
        }
        return $object->name.' '.$object->last_name;
    }

    //******** VALUE OBJECTS ********

    public function getTypeAttribute()
    {
        return new Type($this->userable_type);
    }

    public function getNotificationSettingsAttribute()
    {
        return new notificationSettings($this, resolve(UserHelpers::class));
    }


    //******** Relationships ********

    public function activationToken()
    {
        return $this->hasOne(ActivationToken::class);
    }

    public function admin()
    {
        if($this->isAdministrator()){
            return $this->userable();
        }
        return $this->userable()->admin();
    }

    /**
     * Get the element that this user morphs to
     * @return It could be any of:
     *         Administrator, Client, Supervisor, Technician
     * tested
     */
    public function userable()
    {
        return $this->morphTo()->first();
    }


}
