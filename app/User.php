<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get reports associatod with this user
     */
    public function reports(){
        return $this->hasManyThrough('App\Report', 'App\Service');
    }

    /**
     * Get the reports in this date
     * @param  String $date  YYYY-MM-DD format date
     */
    public function reportsByDate($date){
        $date_carbon = (new Carbon($date))->toDateTimeString();
        return $this->hasManyThrough('App\Report', 'App\Service')
                    ->where(\DB::raw('DATEDIFF(completed, "'.$date_carbon.'")'), '=', '0')
                    ->get();
    }

    public function reportsBySeqId($seq_id){
        return $this->hasManyThrough('App\Report', 'App\Service')
                    ->where('reports.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    /**
     *  Get services associated with this user
     * 
     */
    public function services(){
        return $this->hasMany('App\Service');
    }

    // public function clients(){
    //     return $this->belongsToManyThrough('App\Client', 'App\Service');
    // }

    /**
     *  Get supervisors assaciated with this user
     * 
     */
    public function supervisors(){
        return $this->hasMany('App\Supervisor');
    }
    
    /**
     * Get technicians assaciated with this user
     */
    public function technicians(){
        return $this->hasManyThrough('App\Technician', 'App\Supervisor')->orderBy('seq_id');
    }

}
