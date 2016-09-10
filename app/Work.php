<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use ImageTrait;

    /**
     * variables that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'description',
        'quantity',
        'units',
        'cost',
        'work_order_id',
        'technician_id',
    ];

    /**
     * associated workOrder with this work
     */
    public function workOrder()
    {
    	return $this->belongsTo('App\WorkOrder')->first();
    }

    /**
     * associated technician with this work
     */
    public function technician()
    {
    	return $this->belongsTo('App\Technician')->first();
    }

    /**
     * associated service with this work
     */
    public function service()
    {
        return $this->workOrder()->service();
    }
}
