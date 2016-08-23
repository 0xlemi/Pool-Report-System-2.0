<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Intervention;

use App\PRS\Helpers\ServiceHelpers;
use App\PRS\Traits\Model\ImageTrait;

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
     * check if there is a report for this service already done in a date
     * @param  Carbon $date is in Administrator timezone
     * @return boolean
     */
    public function checkIfIsDone(Carbon $date)
    {
        $admin = $this->admin();
        $strDate = $date->toDateTimeString();
        $count = $this->reports()
                ->where(\DB::raw('DATEDIFF(CONVERT_TZ(completed,\'UTC\',\''.$this->timezone.'\'), "'.$strDate.'")'), '=', '0')
                ->count();
        if($count > 0){
            return true;
        }
        return false;
    }

}
