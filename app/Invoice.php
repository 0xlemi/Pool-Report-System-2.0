<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PRS\Traits\Model\SortableTrait;
use App\PRS\ValueObjects\Invoice\TypeInvoice;
use Carbon\Carbon;

class Invoice extends Model
{

    use SortableTrait;

    /**
     * variables that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'closed',
        'amount',
        'currency',
        'description',
        'admin_id',
    ];

    // ************************
    //        Scopes
    // ************************

    public function scopeBySeqId($query, $seqId)
    {
        return $query->where('invoces.seq_id', $seqId)->findOrFail();
    }

    // *****************************
    //      Relationships
    // *****************************

    public function company()
    {
        return $this->invoiceable->company();
    }

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

    public function totalPayments()
    {
        return $this->payments()->sum('payments.amount');
    }


    //******** VALUE OBJECTS ********

    public function closed()
    {
        return (new Carbon($this->closed, 'UTC'))->setTimezone($this->company->timezone);
    }

    public function type()
    {
        return new TypeInvoice($this->invoiceable_type);
    }

}
