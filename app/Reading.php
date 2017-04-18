<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Report;
use App\Chemical;

class Reading extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'chemical_id'
    ];

    // ******************
    //      Scopes
    // ******************

    public function scopeOfChemical($query, Chemical $chemical)
    {
        return $query->where('chemical_id', $chemical->id)->first();
    }

    // ******************
    //    Relationships
    // ******************

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function chemical()
    {
        return $this->belongsTo(Chemical::class);
    }

    public function globalChemical()
    {
        return $this->chemical->globalChemical();
    }
}
