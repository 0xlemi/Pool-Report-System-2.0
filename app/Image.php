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
    	'image',
    	'image_type',
    	'image_order',
    ];
}
