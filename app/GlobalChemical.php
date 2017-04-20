<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Label;
use App\Company;
use App\PRS\Traits\Model\ImageTrait;

class GlobalChemical extends Model
{

    use ImageTrait;


    /**
	 * variables that can be mass assign
	 * @var array
	 */
	protected $fillable = [
        'name',
        'units',
	];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'company_id',
    ];


    // *******************
    //      Scopes
    // *******************

    public function scopeBySeqId($query, $seqId)
    {
        return $query->where('global_chemicals.seq_id', $seqId)->firstOrFail();
    }

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
