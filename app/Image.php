<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Jobs\DeleteImage;

class Image extends Model
{
    protected $fillable = [
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

}
