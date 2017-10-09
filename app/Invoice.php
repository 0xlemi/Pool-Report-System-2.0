<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PRS\Traits\Model\SortableTrait;
use App\PRS\ValueObjects\Invoice\TypeInvoice;
use App\PRS\Classes\Logged;
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
        'pay_before',
        'company_id',
    ];

    // ************************
    //        Scopes
    // ************************

    public function scopeBySeqId($query, $seqId)
    {
        return $query->where('invoices.seq_id', $seqId)->firstOrFail();
    }

    public function scopePayments($query)
    {
        $paymentsIdArray = $query->join('payments', 'invoices.id', '=', 'payments.invoice_id')
                    ->select('payments.id')->get()->pluck('id')->toArray();

        return Payment::whereIn('payments.id', $paymentsIdArray);
    }

    public function scopeCurrency($query, $currency)
    {
        return $query->where('invoices.currency', $currency);
    }

    public function scopeUnpaid($query)
    {
        return $query->whereNull('invoices.closed');
    }

    public function scopePaid($query)
    {
        return $query->whereNotNull('invoices.closed');
    }

    public function scopeOnDay($query, int $day)
    {
        $invoices = $query->whereDay('invoices.created_at', $day);
    }

    public function scopeOnMonth($query, int $month, int $year = null)
    {
        $company = Logged::company();
        $invoices = $query->whereMonth('invoices.created_at', $month);
        if(!$year){
            $year = Carbon::today($company->timezone)->format('Y');
        }
        return $invoices->whereYear('invoices.created_at', $year);
    }

    public function scopeThisMonth($query)
    {
        $company = Logged::company();
        $month = Carbon::today($company->timezone)->format('m');
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
