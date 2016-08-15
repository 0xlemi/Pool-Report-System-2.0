<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\PRS\Traits\Model\ImageTrait;

use Carbon\Carbon;

class Administrator extends Model
{

    use ImageTrait;

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
		'get_reports_emails',
    ];

    /**
     * hidden variables
     * @var array
     */
	protected $hidden = [

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
     * Get all dates that have at least one report in them
     * @return Collertion
     */
    public function datesWithReport()
    {
        return $this->reports()
                    ->get()
                    ->pluck('completed')
                    ->transform(function ($item) {
                        return substr($item, 0 , 10);
                    })
                    ->unique()
                    ->flatten();
    }

    /**
     * Get reports associatod with this user
     * tested
     */
    public function reports($descending_order = false){
        $order = ($descending_order) ? 'desc' : 'asc';
        return $this->hasManyThrough('App\Report', 'App\Service', 'admin_id')
                    ->orderBy('seq_id', $order);
    }

    /**
     * Total number of services that need to be done today
     * @return int
     */
    public function numberServicesDoToday()
    {
        return $this->NumberServicesDoIn(Carbon::today());
    }

    /**
     * Total number of services that need to be done in a date
     * @param  Carbon $date
     * @return  int
     */
    public function numberServicesDoIn(Carbon $date)
    {
        return $this->servicesDoIn($date, true)->count();
    }

    /**
     * Number of services that are missing in a date
     * @param  Carbon $date
     * @return  int
     */
    public function numberServicesMissing(Carbon $date)
    {
        return $this->servicesDoIn($date)->count();
    }

    /**
     * get the services that need to be done today
     * @param  boolean $AddCompletedReports add or remove services that where already done today
     * @return Collection
     */
    public function servicesDoToday($AddCompletedReports = false)
    {
        $date = Carbon::today();
        return $this->servicesDoIn($date , $AddCompletedReports);
    }

    /**
     * get the services that need to be done in certain date
     * @param  Carbon  $date
     * @param  boolean $AddCompletedReports   add or remove the services that where already done
     * @return Collection
     */
    public function servicesDoIn(Carbon $date, $AddCompletedReports = false)
    {
        return $this->services()
            ->get()
            ->map(function($service) use ($date, $AddCompletedReports){
                // check that the service is do in this date
                if($service->checkIfIsDo($date)){
                    // what to add all the reports or only the ones that are missing for $date
                    if($AddCompletedReports){
                        // add all reports that are do
                        return $service;
                    }else{
                        // check that the report is missing in the $date
                        if(!$service->checkIfIsDone($date)){
                            return $service;
                        }
                    }
                }
            })->reject(function($service){
                return is_null($service);
            });
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
    public function services($descending_order = false){
        $order = ($descending_order) ? 'desc' : 'asc';
        return $this->hasMany('App\Service', 'admin_id')->orderBy('seq_id', $order);
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
    public function clients($descending_order = false){
        $order = ($descending_order) ? 'desc' : 'asc';
        return Client::where('admin_id', $this->id)->orderBy('seq_id', $order);
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
    public function supervisors($descending_order = false){
        $order = ($descending_order) ? 'desc' : 'asc';
        return $this->hasMany('App\Supervisor', 'admin_id')
                    ->orderBy('seq_id', $order);
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
    public function technicians($descending_order = false){
        $order = ($descending_order) ? 'desc' : 'asc';
        return $this->hasManyThrough(
                        'App\Technician',
                        'App\Supervisor',
                        'admin_id')
                    ->orderBy('seq_id', $order);
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
