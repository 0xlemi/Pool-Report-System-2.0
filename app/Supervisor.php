<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{

	/**
	 * variables that can be mass assign
	 * @var array
	 */
	protected $fillable = [
		'name',
		'last_name',
		'cellphone',
		'address',
		'email',
		'comments',
	];
    
    /**
     * hidden variables
     * @var array
     */
	protected $hidden = [
		'password',
	];

    /**
     *	Get the associated user to this supervisor
     * 
     */
	public function user(){
		return $this->belongsTo('App\User');
	}

	/**
	 * Get the associated technicians to this supervisor
	 * 
	 */
	public function technicians(){
		return $this->hasMany('App\Technician');
	}

}
