<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\PRS\Traits\Model\ImageTrait;

class WorkOrder extends Model
{

    use ImageTrait;

    /**
     * variables that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'start',
        'end',
        'finished',
        'price',
        'currency',
        'service_id',
        'supervisor_id',
    ];

    /**
     * associated service with this workOrder
     */
    public function service()
    {
    	return $this->belongsTo('App\Service')->first();
    }

    /**
     * associated supervisor with this workOrder
     */
    public function supervisor()
    {
    	return $this->belongsTo('App\Supervisor')->first();
    }

    /**
     * Get associated works with this work Order
     */
    public function works()
    {
    	return $this->hasMany('App\Work');
    }

}
