<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use App\PRS\Traits\Model\ImageTrait;
use App\PRS\ValueObjects\WorkOrder\End;

use Carbon\Carbon;

class WorkOrder extends Model
{

    use ImageTrait;

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
        'user_role_client_id',
    ];

    /**
     * associated service with this workOrder
     */
    public function service()
    {
    	return $this->belongsTo('App\Service');
    }

    /**
     * associated administrator with this workOrder
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


    //******** VALUE OBJECTS ********

    /**
     * Start date in the admin timezone
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



}
