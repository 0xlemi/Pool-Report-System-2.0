<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\PRS\Traits\Model\ImageTrait;

class Work extends Model
{
    use ImageTrait;

    /**
     * variables that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'quantity',
        'units',
        'cost',
        'technician_id',
    ];

    /**
     * hidden variables
     * @var array
     */
    protected $hidden = [
        'work_order_id',
    ];

    /**
     * associated workOrder with this work
     */
    public function workOrder()
    {
    	return $this->belongsTo('App\WorkOrder');
    }

    /**
     * associated technician with this work
     */
    public function technician()
    {
    	return $this->belongsTo('App\Technician');
    }

    /**
     * associated service with this work
     */
    public function service()
    {
        return $this->workOrder->service;
    }
}
