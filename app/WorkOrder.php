<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use App\PRS\Traits\Model\ImageTrait;

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
        'end',
        'finished',
        'price',
        'currency',
        'service_id',
        'supervisor_id',
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
    public function admin()
    {
        return $this->service()->admin();
    }

    /**
     * associated supervisor with this workOrder
     */
    public function supervisor()
    {
    	return $this->belongsTo('App\Supervisor');
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
        return (new Carbon($this->start, 'UTC'))->setTimezone($this->admin()->timezone);
    }

    /**
     * End date in the admin timezone
     * @return Carbon
     */
    public function end()
    {
        return (new Carbon($this->end, 'UTC'))->setTimezone($this->admin()->timezone);
    }



}
