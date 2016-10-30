<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Service;

use App\PRS\Helpers\ServiceHelpers;
use App\PRS\ValueObjects\Service\EndTime;
use App\PRS\ValueObjects\Service\ServiceDays;
use App\PRS\ValueObjects\Service\Status;

class ServiceContract extends Model
{

    /**
     * variables that can be mass assign
     * @var array
     */
    protected $fillable = [
        'active',
        'service_days',
        'amount',
        'currency',
        'start_time',
        'end_time',
        'comments',
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

    //******** VALUE OBJECTS ********

    // /**
    //  * endTime ValueObject
    //  * @return EndTime
    //  */
    // public function endTime()
    // {
    //     $reportHelpers = \App::make('App\PRS\Helpers\ReportHelpers');
    //     return (new EndTime($this->serviceContract->end_time, $this->admin()->timezone, $reportHelpers));
    // }

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
    public function contractActive()
    {
        return (new Status($this->active));
    }


}
