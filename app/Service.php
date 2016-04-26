<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * variables that can be mass assign
     * @var array
     */
    protected $fillable = [
        'name',
        'address_line_1',
        'address_line_2',
        'state',
        'postal_code',
        'country',
        'type',
        'service_days',
        'amount',
        'currency',
        'start_time',
        'end_time',
        'status',
        'image',
        'tn_image',
        'comments',
    ];


	/**
	 * Get the associated user with this service
	 */
    public function user(){
    	return $this->belongsTo('App\User');
    }

    /**
     * Get the associated clients with this service
     */
    public function clients(){
    	return $this->belongsToMany('App\Client');
    }

    /**
     * Get associated reports with this service
     */
    public function reports(){
    	return $this->hasMany('App\Report');
    }

    /**
     * Associated reports with this service
     */
    public function images(){
        return $this->hasMany('App\Image');
    }

    /**
     * Get the extra small image
     */
    public function icon(){
        return $this->hasMany('App\Image')
            ->where('image_type', '=', 'S')
            ->first()->image;
    }
}
