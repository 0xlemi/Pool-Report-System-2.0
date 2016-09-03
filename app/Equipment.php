<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PRS\Traits\Model\ImageTrait;

class Equipment extends Model
{

    use ImageTrait;

    /**
	 * variables that can be mass assign
	 * @var array
	 */
	protected $fillable = [
        'kind',
        'type',
        'brand',
        'model',
        'capacity',
        'units'
	];


    /**
     * hidden variables
     * @var array
     */
	protected $hidden = [
        'service_id'
	];

    public function service()
    {
		return $this->belongsTo('App\Service')->first();
    }

}
