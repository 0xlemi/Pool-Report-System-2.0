<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Service;

use App\PRS\Helpers\ServiceHelpers;
use App\PRS\ValueObjects\Service\EndTime;
use App\PRS\ValueObjects\Service\StartTime;
use App\PRS\ValueObjects\Service\ServiceDays;
use App\PRS\ValueObjects\Service\Status;

class ServiceContract extends Model
{

    /**
     * variables that can be mass assign
     * @var array
     */
    protected $fillable = [
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
        'service_id'
	];

    protected $primaryKey = 'service_id';


    //******** RELATIONSHIPS ********

    /**
     * get Service associated with this ServiceContract
     * tested
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function admin()
    {
        return $this->service->admin();
    }

    //******** VALUE OBJECTS ********

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
    public function active()
    {
        return (new Status($this->active));
    }


}
