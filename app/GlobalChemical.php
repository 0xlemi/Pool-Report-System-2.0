<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Label;
use App\Company;

class GlobalChemical extends Model
{
    /**
	 * variables that can be mass assign
	 * @var array
	 */
	protected $fillable = [
        'name',
        'units',
	];

    // *******************
    //    Relationships
    // *******************

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function labels()
    {
        return $this->hasMany(Label::class);
    }

}
