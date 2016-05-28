<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
        'website',
        'facebook',
        'twitter',
        'timezone',
    ];
}
