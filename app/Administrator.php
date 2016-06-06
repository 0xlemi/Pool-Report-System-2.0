<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use Carbon\Carbon;

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

    /**
     * Get the user this administrator is morphed by
     * @return $user
     * tested
     */
    public function user()
    {
        return $this->morphOne('App\User', 'userable')->first();
    }

    /**
     * Get reports associatod with this user
     * tested
     */
    public function reports(){
        return $this->hasManyThrough('App\Report', 'App\Service', 'admin_id')
                    ->orderBy('seq_id');
    }

    /**
     * Get the reports in this date
     * @param  String $date  YYYY-MM-DD format date
     * tested
     */
    public function reportsByDate($date){
        $date_carbon = (new Carbon($date))->toDateTimeString();
        return $this->hasManyThrough('App\Report', 'App\Service', 'admin_id')
                    ->where(\DB::raw('DATEDIFF(completed, "'.$date_carbon.'")'), '=', '0')
                    ->orderBy('seq_id');
    }

    /**
     * Get the reports based on the seq_id
     * @param  integer $seq_id
     * @return $report
     * tested
     */
    public function reportsBySeqId($seq_id){
        return $this->hasManyThrough('App\Report', 'App\Service', 'admin_id')
                    ->where('reports.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    /**
     *  Get services associated with this user
     * tested
     */
    public function services(){
        return $this->hasMany('App\Service', 'admin_id')->orderBy('seq_id');
    }

    /**
     * Get services accacited with this user and seq_id convination
     * @param  int $seq_id
     * tested
     */
    public function serviceBySeqId($seq_id){
        return $this->hasMany('App\Service', 'admin_id')
                    ->where('services.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    public function clientsThroughServices(){
        $this->load('services.clients'); // eager load far relation
        $clients = new Collection; // Illuminate\Database\Eloquent\Collection

        foreach ($this->services as $service)
        {
           $clients = $clients->merge($service->clients);
        }

        $clients = $clients->unique()->sortBy('seq_id'); // remove the duplicates

        return $clients; // all clients collection
    }

    /**
     * Get clients associated with this user
     * tested
     */
    public function clients(){
        return Client::where('admin_id', $this->id)->orderBy('seq_id');
    }

    /**
     * Get clients accacited with this user and seq_id convination
     * @param  int $seq_id
     * tested
     */
    public function clientsBySeqId($seq_id){
        return Client::where('admin_id', $this->id)
                    ->where('clients.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    /**
     * Get supervisors assaciated with this user
     * tested
     */
    public function supervisors(){
        return $this->hasMany('App\Supervisor', 'admin_id')
                    ->orderBy('seq_id');
    }

    /**
     * Get supervisor accacited with this user and seq_id convination
     * @param  int $seq_id
     * tested
     */
    public function supervisorBySeqId($seq_id){
        return $this->hasMany('App\Supervisor', 'admin_id')
                    ->where('supervisors.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    /**
     * Get technicians assaciated with this user
     * tested
     */
    public function technicians(){
        return $this->hasManyThrough(
                        'App\Technician',
                        'App\Supervisor',
                        'admin_id')
                    ->orderBy('seq_id');
    }

    /**
     * Get technicains associated with this user and seq_id convination
     * @param  int $seq_id
     * tested
     */
    public function technicianBySeqId($seq_id){
        return $this->hasManyThrough(
                        'App\Technician',
                        'App\Supervisor',
                        'admin_id')
                    ->where('technicians.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

}
