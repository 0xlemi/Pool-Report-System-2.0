<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    /**
     * variables that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'closed',
        'amount',
        'currency',
        'admin_id',
    ];

    /**
     * Get all the commentable object
     */
    public function invoiceable()
    {
        return $this->morphTo();
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }
}
