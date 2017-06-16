<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentSources extends Model
{
    /**
     * variables that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'card_id',
        'brand',
        'country',
        'fouding',
        'last4',
    ];


}
