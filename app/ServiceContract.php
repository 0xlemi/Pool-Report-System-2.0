<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Service;

class ServiceContract extends Model
{

    /**
     * variables that can be mass assign
     * @var array
     */
    protected $fillable = [
        'service_days',
        'amount',
        'currency',
        'start_time',
        'end_time',
        'active',
        'comments',
    ];


    //******** RELATIONSHIPS ********

    public function service()
    {
        return $this->belongsTo(Service::class);
    }


}
