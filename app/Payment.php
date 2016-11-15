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

    public function admin()
    {
        return $this->invoice->admin();
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    //******** VALUE OBJECTS ********

    public function createdAt()
    {
        return $this->created_at->setTimezone($this->admin()->timezone);
    }

}
