<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Jobs\DeleteImage;

class Image extends Model
{
    protected $fillable = [
    	'report_id',
    	'technician_id',
    	'supervisor_id',
    	'client_id',
    	'service_id',
        'big',
    	'medium',
        'thumbnail',
        'icon',
        'type',
    	'order',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function delete()
    {
        // Delete the image files from s3
        dispatch(new DeleteImage($this->big, $this->medium, $this->thumbnail, $this->icon));
        return parent::delete();
    }

}
