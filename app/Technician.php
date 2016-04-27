<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
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
		'username',
		'image',
		'tn_image',
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
	 * associated supervisor with this technician
	 */
    public function supervisor(){
    	return $this->belongsTo('App\Supervisor');
    }

	/**
	 * assaciated reports with this technician
	 */
    public function reports(){
    	return $this->hasMany('App\Report');
    }

    /**
     * Associated reports with this technician
     */
    public function user(){
    	$user_id = Supervisor::findOrFail($this->supervisor_id)->user_id;
    	return User::findOrFail($user_id);
    }

    /**
     * Associated reports with this technician
     */
    public function images(){
    	return $this->hasMany('App\Image');
    }

    /**
     * Get the extra small image
     */
    public function icon(){
    	return $this->hasMany('App\Image')
    		->where('images.type', '=', 'S')
           	->first()->path;
    }
}
