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

    public function company()
    {
        return $this->invoice->company();
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    //******** VALUE OBJECTS ********

    public function createdAt()
    {
        return $this->created_at->setTimezone($this->company->timezone);
    }

}
