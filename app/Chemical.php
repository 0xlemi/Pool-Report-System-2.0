<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Service;
use App\Reading;
use App\GlobalChemical;

class Chemical extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'global_chemical_id'
    ];

    // *******************
    //    Relationships
    // *******************

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function globalChemical()
    {
        return $this->belongsTo(GlobalChemical::class);
    }

    public function readings()
    {
        return $this->hasMany(Reading::class);
    }

}
