<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use App\PRS\Traits\Model\ImageTrait;
use App\PRS\Traits\Model\SortableTrait;
use App\PRS\ValueObjects\WorkOrder\End;
use App\Invoice;

use Carbon\Carbon;

class WorkOrder extends Model
{

    use ImageTrait;
    use SortableTrait;

    /**
     * variables that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'start',
        'price',
        'currency',
        'user_role_company_id',
    ];



    // ************************
    //      VALUE OBJECTS
    // ************************

    /**
     * Start date in the company timezone
     * @return Carbon
     */
    public function start()
    {
        return (new Carbon($this->start, 'UTC'))->setTimezone($this->company->timezone);
    }

    /**
     * End date in the admin timezone
     * @return Carbon
     */
    public function end()
    {
        return new End($this->end, $this->company->timezone);
    }


    // ************************
    //        Scopes
    // ************************

    public function scopeBySeqId($query, $seqId)
    {
        return $query->where('work_orders.seq_id', $seqId)->firstOrFail();
    }

    public function scopeInvoices($query)
    {
        $invoicesIdArray = $query->join('invoices', function ($join) {
                $join->on('work_orders.id', '=', 'invoices.invoiceable_id')
                     ->where('invoices.invoiceable_type', '=', 'App\WorkOrder');
            })->select('invoices.id')->get()->pluck('id')->toArray();
        return Invoice::whereIn('invoices.id', $invoicesIdArray);
    }

    public function scopeFinished($query, $finished = true)
    {
        $operator = ($finished) ? '!=' : '=';
        return $query->where('end', $operator, null);
    }


    // ************************
    //      Relationships
    // ************************

    /**
     * associated service with this workOrder
     */
    public function service()
    {
    	return $this->belongsTo('App\Service');
    }

    /**
     * associated company with this workOrder
     */
    public function company()
    {
        return $this->service->company();
    }

    /**
     * associated UserRoleCompany with this workOrder
     */
    public function userRoleCompany()
    {
    	return $this->belongsTo(UserRoleCompany::class);
    }

    /**
	 * Gets ServiceContract morphed Invoices
	 */
	public function invoices()
    {
      return $this->morphMany('App\Invoice', 'invoiceable');
    }

    /**
     * Get associated works with this work Order
     */
    public function works()
    {
    	return $this->hasMany('App\Work');
    }

    /**
     * images before any work has been done
     * @return Collection
     */
    public function imagesBeforeWork()
    {
        return $this->imagesByType(1);
    }

    /**
     * images after the work was completed
     * @return Collection
     */
    public function imagesAfterWork()
    {
        return $this->imagesByType(2);
    }



}
