<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Service;

class MissingHistory extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'num_services_missing',
        'num_services_done'
    ];

    public function services()
    {
        return $this->belongsToMany( Service::class, 'missing_history_service');
    }

}
