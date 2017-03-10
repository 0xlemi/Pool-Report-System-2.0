<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Service;

use App\PRS\Helpers\ServiceHelpers;
use App\PRS\ValueObjects\Service\EndTime;
use App\PRS\ValueObjects\Service\StartTime;
use App\PRS\ValueObjects\Service\ServiceDays;
use App\PRS\ValueObjects\Service\Status;
use App\PRS\ValueObjects\ServiceContract\Start;
use Carbon\Carbon;

class ServiceContract extends Model
{

    /**
     * variables that can be mass assign
     * @var array
     */
    protected $fillable = [
        'start',
        'active',
        'service_days',
        'amount',
        'currency',
        'start_time',
        'end_time',
        'comments',
    ];

    /**
     * hidden variables
     * @var array
     */
	protected $hidden = [
        // 'service_id'
	];

    //******** RELATIONSHIPS ********

    /**
     * get Service associated with this ServiceContract
     * tested
     */
    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function admin()
    {
        return $this->service->admin();
    }

    /**
	 * Gets ServiceContract morphed Invoices
	 */
	public function invoices()
    {
      return $this->morphMany('App\Invoice', 'invoiceable');
    }

    /**
     * Check if there is atleast one invoice for for this service contract in this date
     * @param  Carbon $date  is on admin timezone
     * @return boolean
     */
    public function invoicedByDate(Carbon $date)
    {
        $admin = $this->admin();
        $strDate = $date->toDateTimeString();
        $count = $this->invoices()
                ->where(\DB::raw('DATEDIFF(CONVERT_TZ(created_at,\'UTC\',\''.$admin->timezone.'\'), "'.$strDate.'")'), '=', '0')
                ->count();
        if($count > 0){
            return true;
        }
        return false;
    }

    public function checkIfTodayContractChargesInvoice()
    {
        // we dont charge unactive services
        if(!$this->active){
            return false;
        }

        $today = Carbon::today($this->admin()->timezone);
        // check for another invoice linked to the service contract in the same day
        // so we dont generate duplicate invoices
        if($this->invoicedByDate($today)){
            return false;
        }

        $contractStartDate = Carbon::parse($this->start, $this->admin()->timezone);
        // check that is the date of the month
        // for this service contract
        return ($today->format('d') == $contractStartDate->format('d'));

    }

    //******** VALUE OBJECTS ********

    /**
     * Start ValueObject
     * @return Start
     */
    public function start()
    {
        return (new Start($this->start));
    }

    /**
     * EndTime ValueObject
     * @return EndTime
     */
    public function endTime()
    {
        $reportHelpers = \App::make('App\PRS\Helpers\ReportHelpers');
        return (new EndTime($this->end_time, $this->admin()->timezone, $reportHelpers));
    }

    /**
     * StartTime ValueObject
     * @return StartTime
     */
    public function startTime()
    {
        return (new StartTime($this->start_time));
    }

    /**
     * ServiceDays ValueObject
     * @return ServiceDays
     */
    public function serviceDays()
    {
        return (new ServiceDays($this->service_days));
    }

    /**
     * status ValueObject
     * @return [type] [description]
     */
    public function activeStatus()
    {
        return (new Status($this->active));
    }


}
