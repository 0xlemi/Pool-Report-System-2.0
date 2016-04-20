<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

	/**
	 * variables that can be mass assign
	 * @var array
	 */
	protected $fillable = [
		'name',
		'last_name',
		'cellphone',
		'email',
		'image',
		'tn_image',
		'type',
		'email_preferences',
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
	 * associated services with this client
	 */
    public function services(){
    	return $this->belongsToMany('App\Service');
    }
}
