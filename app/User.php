<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use App\PRS\ValueObjects\All\Type;
use App\PRS\ValueObjects\User\NotificationSettings;
use App\PRS\Helpers\UserHelpers;
use App\PRS\Traits\Model\ImageTrait;

use Hash;
use App\Notifications\ResetPasswordNotification;
use App\Company;
use App\UserRoleCompany;
use App\UrlSigner;

class User extends Authenticatable
{
	use ImageTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
		'name',
		'last_name',
		'language',

        // 'remember_token',
        // 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        // 'api_token',

    ];

    protected $appends = [
        'fullName',
		'notificationSettings',
		'selectedUser'
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
	 * Check if between the user's UserRoleCompany if it has one of the roles
	 * and is associated to the company
	 * @param  Company  $company
	 * @param  array 	$roles   	strings with the name of the roles
	 * @return boolean
	 */

	public function hasRolesWithCompany(Company $company, ...$roles)
	{
		$urcFromCompany = $this->userRoleCompanies()->where('company_id', $company->id);
		// not working
		return ($urcFromCompany->ofRole(...$roles)->count() > 0);
	}

    public function checkPassword($password)
    {
        return (Hash::check($password, $this->password));
    }


	// ********** Attributes ************

    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->last_name;
    }

	public function getSelectedUserAttribute()
	{
		try {
			$selectedUser = $this->userRoleCompanies()->where('selected', true)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			$selectedUser = $this->userRoleCompanies()->first();
		}
		return $selectedUser;
	}


    //******** VALUE OBJECTS ********

    // public function getNotificationSettingsAttribute()
    // {
    //     return new notificationSettings($this, resolve(UserHelpers::class));
    // }


    //******** Relationships ********

    public function activationToken()
    {
        return $this->hasOne(ActivationToken::class);
    }

    public function userRoleCompanies()
    {
        return $this->hasMany(UserRoleCompany::class);
    }


}
