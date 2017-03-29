<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use App\PRS\ValueObjects\All\Type;
use App\PRS\ValueObjects\User\NotificationSettings;
use App\PRS\Helpers\UserHelpers;
use App\PRS\Traits\Model\ImageTrait;

use Hash;
use App\Notifications\ResetPasswordNotification;
use App\PRS\Traits\Model\BillableAdministrator;
use App\UserRoleCompany;
use App\UrlSigner;

class User extends Authenticatable
{
	use ImageTrait;
    use Notifiable;
    use BillableAdministrator;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        // delete this from the fillable filleds
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
        'free_objects',
        'stripe_id',
        'card_brand',
        'card_last_four',
        'trial_ends_at'
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
    public function checkPassword($password)
    {
        return (Hash::check($password, $this->password));
    }

    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->last_name;
    }

    //******** VALUE OBJECTS ********

    public function getNotificationSettingsAttribute()
    {
        return new notificationSettings($this, resolve(UserHelpers::class));
    }


    //******** Relationships ********

    public function activationToken()
    {
        return $this->hasOne(ActivationToken::class);
    }

    public function userRoleCompany()
    {
        $this->hasMany(UserRoleCompany::class);
    }


}
