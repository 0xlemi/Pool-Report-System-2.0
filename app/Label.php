<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GlobalMeasurement;

class Label extends Model
{
    /**
	 * variables that can be mass assign
	 * @var array
	 */
	protected $fillable = [
        'name',
        'color',
        'value',
	];

    // ******************
    //      Scopes
    // ******************

    public function scopeWhereValue($query, int $value)
    {
        if($label = $query->where('labels.value', $value)->first()){
            return $label;
        }
        return collect([
            'name' => 'Unknown',
            'color' => 'ADB7BE',
            'value' => 0,
        ]);
    }

    // ******************
    //   Relationships
    // ******************

    public function globalMeasurement()
    {
        $this->belongsTo(GlobalMeasurement::class);
    }

}
