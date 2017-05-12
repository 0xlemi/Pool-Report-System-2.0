<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Report;
use App\Measurement;

class Reading extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'measurement_id'
    ];

    // ******************
    //      Scopes
    // ******************

    public function scopeMeasurement($query)
    {
        $measurementIds = $query->pluck('measurement_id');
        return Measurement::whereIn('id', $measurementIds);
    }

    // ******************
    //    Relationships
    // ******************

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function measurement()
    {
        return $this->belongsTo(Measurement::class);
    }

    public function globalMeasurement()
    {
        return $this->measurement->globalMeasurement();
    }
}
