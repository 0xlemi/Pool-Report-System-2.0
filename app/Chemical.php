<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chemical extends Model
{
    //

    /**
	 * variables that can be mass assign
	 * @var array
	 */
	protected $fillable = [
        'name',
        'amount',
        'units',
	];

    public function service()
    {
		return $this->belongsTo('App\Service');
    }

}
