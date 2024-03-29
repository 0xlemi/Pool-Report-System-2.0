<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{

    /**
     * variables that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'amount',
        'method'
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

    public function scopeOnTime($query, $isOnTime = true)
    {
        $operator = '<';
        if($isOnTime){
            $operator = '>';
        }
        return $query->join('invoices', 'payments.invoice_id', '=', 'invoices.id')
                        ->select('payments.*', 'invoices.pay_before')
                        ->whereDate('pay_before', $operator, Carbon::now());
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
