<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PRS\Traits\Model\ImageTrait;
use App\Company;

class GlobalProduct extends Model
{

    use ImageTrait;

    /**
     * variables that can be mass assign
     * @var array
     */
    protected $fillable = [
        'name',
        'brand',
        'type',
        'units',
        'unit_price',
        'unit_currency',
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
        return $query->where('global_products.seq_id', $seqId)->firstOrFail();
    }

    // *******************
    //    Relationships
    // *******************

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


}
