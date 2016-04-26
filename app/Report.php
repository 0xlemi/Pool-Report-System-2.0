<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Report extends Model
{

    /**
     * variables that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'completed',
        'on_time',
        'ph',
        'clorine',
        'temperature',
        'turbidity',
        'salt',
        'image_1',
        'image_2',
        'image_3',
        'tn_image_1',
        'tn_image_2',
        'tn_image_3',
        'latitude',
        'longitude',
        'altitude',
        'accuracy',
    ];
    
    /**
     * associated service with this report
     */
    public function service(){
    	return $this->belongsTo('App\Service');
    }

    /**
     * associated technician with this report
     */
    public function technician(){
    	return $this->belongsTo('App\Technician');
    }
}
