<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Intervention;

use App\PRS\Helpers\ServiceHelpers;
use App\PRS\Traits\Model\ImageTrait;
use App\PRS\Classes\ValueObjects\EndTime;

use Carbon\Carbon;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Service extends Model
{
    use ImageTrait;

    /**
     * variables that can be mass assign
     * @var array
     */
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'address_line',
        'city',
        'state',
        'postal_code',
        'country',
        'type',
        'service_days',
        'amount',
        'currency',
        'start_time',
        'end_time',
        'status',
        'comments',
        'admin_id',
    ];


    /**
     * hidden variables
     * @var array
     */
    protected $hidden = [
        'admin_id',
    ];

    public function endTime()
    {
        $reportHelpers = \App::make('App\PRS\Helpers\ReportHelpers');
        return (new EndTime($this, $reportHelpers));
    }

    /**
	 * Get the associated Administrator with this service
	 * tested
	 */
    public function admin(){
    	return $this->belongsTo('App\Administrator')->first();
    }

    /**
     * Get the associated clients with this service
     * tested
     */
    public function clients(){
    	return $this->belongsToMany('App\Client');
    }

    /**
     * Get associated reports with this service
     * tested
     */
    public function reports(){
    	return $this->hasMany('App\Report');
    }

    /**
     * Get associated equipment with this service
     */
    public function equipment(){
    	return $this->hasMany('App\Equipment');
    }

    /**
     * Get associated work orders with this service
     */
    public function workOrders(){
    	return $this->hasMany('App\WorkOrder');
    }

    public function hasWorkOrders()
    {
        return ($this->workOrders()->get()->count() > 0);
    }

    /**
     * get the service days as a boolean for each day insted of the number
     * @return array
     * tested
     */
    public function service_days_by_day(){
        $serviceHelpers = \App::make('App\PRS\Helpers\ServiceHelpers');
        return $serviceHelpers->num_to_service_days($this->service_days);
    }

    /**
     * check if this service is scheduled for a date
     * tested
     * @param  Carbon $date is in Administrator timezone
     * @return boolean
     */
    public function checkIfIsDo(Carbon $date)
    {
        $admin = $this->admin();
        $dayToCheck = strtolower($date->format('l'));
        return $this->service_days_by_day()[$dayToCheck];
    }

    /**
     * check if there is a single report for this service already done in a date
     * tested
     * @param  Carbon $date is in Administrator timezone
     * @return boolean
     */
    public function checkIfIsDone(Carbon $date)
    {
        $admin = $this->admin();
        $strDate = $date->toDateTimeString();
        $count = $this->reports()
                ->where(\DB::raw('DATEDIFF(CONVERT_TZ(completed,\'UTC\',\''.$admin->timezone.'\'), "'.$strDate.'")'), '=', '0')
                ->count();
        if($count > 0){
            return true;
        }
        return false;
    }

}
