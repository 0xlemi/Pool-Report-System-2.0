<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GlobalChemical;

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
    //   Relationships
    // ******************

    public function globalChemical()
    {
        $this->belongsTo(GlobalChemical::class);
    }

}
