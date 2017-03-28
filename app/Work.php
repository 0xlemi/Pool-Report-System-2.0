<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\PRS\Traits\Model\ImageTrait;
use App\UserRoleCompany;

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
        'user_role_client_id',
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
     * associated UserRoleCompany with this work
     */
    public function userRoleCompany()
    {
    	return $this->belongsTo(UserRoleCompany::class);
    }

    /**
     * associated service with this work
     */
    public function service()
    {
        return $this->workOrder->service;
    }
}
