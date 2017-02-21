<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Intervention;
use App\PRS\Traits\Model\ImageTrait;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use App\User;

class Supervisor extends Model
{

    use ImageTrait;

	/**
	 * variables that can be mass assign
	 * @var array
	 */
	protected $fillable = [
		'name',
		'last_name',
		'cellphone',
		'address',
		'language',
		'comments',
	];

    /**
     * hidden variables
     * @var array
     */
	protected $hidden = [
	];

    /**
     *	Get the associated user to this supervisor
     * tested
     */
	public function admin(){
		return $this->belongsTo('App\Administrator', 'admin_id')->first();
	}

	/**
	 * Get user that this supervisor morphs to
	 * @return $User
	 * tested
	 */
	public function user()
    {
      return $this->morphOne('App\User', 'userable');
    }

	/**
	 * Get the associated technicians to this supervisor
	 * tested
	 */
	public function technicians(){
		return $this->hasMany('App\Technician');
	}


}
