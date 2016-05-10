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

	/**
     * associated images with this report
     */
    public function images(){
        return $this->hasMany('App\Image');
    }

     /**
     * get the number of images this service has
     */
    public function numImages(){
        return $this->hasMany('App\Image')->count();
    }

    /**
     * get full size image
     */
    public function image(){
        if($this->numImages() > 0){
            return $this->hasMany('App\Image')
                ->first()->normal_path;
        }
        return 'img/no_image.png';
    }

    /**
     * get thumbnail image
     */
    public function thumbnail(){
        if($this->numImages() > 0){
            return $this->hasMany('App\Image')
                ->first()->thumbnail_path;
        }
        return 'img/no_image.png';
    }

    /**
     * Get the extra small image
     */
    public function icon(){
        if($this->numImages() > 0){
            return $this->hasMany('App\Image')
                ->first()->icon_path;
        }
        return 'img/avatar-2-48.png';
    }

}
