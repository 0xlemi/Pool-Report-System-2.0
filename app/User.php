<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use App\PRS\ValueObjects\All\Type;
use App\PRS\ValueObjects\User\NotificationSettings;
use App\PRS\Helpers\UserHelpers;
use App\PRS\Traits\Model\ImageTrait;

use Hash;
use App\Notifications\ResetPasswordNotification;
use App\VerificationToken;
use App\Company;
use App\UserRoleCompany;
use App\UrlSigner;

class User extends Authenticatable
{
	use ImageTrait;
	use HasApiTokens;


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
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'fullName',
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
		$this->selectedUser->notify(new ResetPasswordNotification($token));
    }

	public function selectUserRoleCompany(UserRoleCompany $userRoleCompany)
	{
		// Deselect all userRoleCompanies
		$this->userRoleCompanies()->update(['selected' => 0]);
		// Select a userRoleCompany
		$userRoleCompany->selected = 1;
		return $userRoleCompany->save();
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



    //******** Relationships ********

    public function userRoleCompanies()
    {
        return $this->hasMany(UserRoleCompany::class);
    }


}
