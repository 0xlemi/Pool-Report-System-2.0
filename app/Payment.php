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


    // **************************
    //      VALUE OBJECTS
    // **************************

    public function createdAt()
    {
        return $this->created_at->setTimezone($this->company->timezone);
    }

    // ************************
    //        Scopes
    // ************************

    public function scopeBySeqId($query, $seqId)
    {
        return $query->where('payments.seq_id', $seqId)->firstOrFail();
    }

    // ************************
    //      Relationships
    // ************************

    public function company()
    {
        return $this->invoice->company();
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

}
