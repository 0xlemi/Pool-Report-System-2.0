<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
    	'report_id',
    	'technician_id',
    	'supervisor_id',
    	'client_id',
    	'service_id',
    	'normal_path',
        'thumbnail_path',
        'icon_path',
        'type',
    	'order',
    ];

}
