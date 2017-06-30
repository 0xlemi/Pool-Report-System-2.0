<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PRS\Traits\Model\SortableTrait;
use App\PRS\ValueObjects\Invoice\TypeInvoice;
use App\Payment;
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
        'company_id',
    ];

    // ************************
    //        Scopes
    // ************************

    public function scopeBySeqId($query, $seqId)
    {
        return $query->where('invoices.seq_id', $seqId)->firstOrFail();
    }

    public function scopeCurrency($query, $currency)
    {
        return $query->where('invoices.currency', $currency);
    }

    public function scopeUnpaid($query)
    {
        return $query->whereNull('invoices.closed');
    }

    public function scopePaid()
    {
        return $query->whereNotNull('invoices.closed');
    }

    /**
     * Get the total amount subtracting the payment amounts
     * NOTE: make sure you only send services of the same currency otherwise is not gonig to work
     * @param  $query  Illuminate\Database\Query\Builder
     * @return Int       Total sum minus the sum of the payments
     */
    public function scopeSumSubtractingPayments($query)
    {
        $sumPayments = $query->join('payments', 'invoices.id', '=', 'payments.invoice_id')->sum('payments.amount');
        $sumInvoices = $query->sum('invoices.amount');
        return (integer)($sumInvoices - $sumPayments);
    }

    public function scopeOnMonth($query, int $month, int $year = null)
    {
        $invoices = $query->whereMonth('invoices.created_at', $month);
        if(!$year){
            $year = Carbon::today()->format('Y');
        }
        return $invoices->whereYear('invoices.created_at', $year);
    }

    public function scopeThisMonth($query)
    {
        $month = Carbon::today()->format('m');
        return $query->onMonth($month);
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
        return $this->hasMany(Payment::class);
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
