<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    /**
     * variables that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'amount',
    ];

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

}
