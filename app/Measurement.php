<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Service;
use App\Reading;
use App\GlobalMeasurement;

class Measurement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'global_measurement_id'
    ];

    // *******************
    //    Relationships
    // *******************

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function globalMeasurement()
    {
        return $this->belongsTo(GlobalMeasurement::class);
    }

    public function readings()
    {
        return $this->hasMany(Reading::class);
    }

}
