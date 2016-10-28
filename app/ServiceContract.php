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
        'active',
        'service_days',
        'amount',
        'currency',
        'start_time',
        'end_time',
        'comments',
    ];

    protected $primaryKey = 'service_id';


    //******** RELATIONSHIPS ********

    /**
     * get Service associated with this ServiceContract
     * tested
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }


}
